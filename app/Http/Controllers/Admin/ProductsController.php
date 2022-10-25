<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('id' , 'desc')->paginate(10);
        return view('admin.product.index' , compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select(['id','name'])->get();
        $products   = Product::all();
        return view('admin.product.create' , compact('categories','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validation
         $request->validate([
            'name' => 'required|string',
            'image' => 'required',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quntity' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Upload Image
        $new_image = rand().rand().time().$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/images/products') , $new_image);

        // Save Date TO Datebase 
        Product::create([
            'name' => $request->name,
            'image' => $new_image,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quntity' => $request->quntity,
            'category_id' => $request->category_id,            
        ]);

        // Redirect

        return redirect()->route('admin.products.index')->with('msg' , 'Product Added Successfully')->with('type' , 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::with('product')->get();
        return view('admin.product.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // Validation
         $request->validate([
            'name' => 'required|string',
            // 'image' => 'required',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quntity' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $product = Product::findOrFail($id); 

        $new_image = $product->image;
        if($request->hasFile('image')){
            // Upload Image
            $new_image = rand().rand().time().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/images/products/') , $new_image);
        }
        
        // Save Date TO Datebase 
        $product->update([
            'name' => $request->name,
            'image' => $new_image,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quntity' => $request->quntity, 
            'category_id' => $request->category_id,            
        ]);

        // Redirect

        return redirect()->route('admin.products.index')->with('msg' , 'Product Updated Successfully')->with('type' , 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Image
        if(file_exists(public_path('uploads/images/' , $product->image))){
            File::delete(public_path('uploads/images/' , $product->image));
        }

        // Set Parent_Id To NUll
        Product::where('parent_id' , $product->id)->update(['parent_id' => null]);

        // Delete An Item
        $product->delete();

        //Redirect 
        return redirect()->route('admin.products.index')->with('msg' , 'Product Deleted Successfully')->with('type' , 'warning');
    }
}
