<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
     public function add_to_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);

        if($product->sale_price){
            $price = $product->sale_price;
        }else{
            $price = $product->price;
        }

        $cart = Cart::where('user_id' , Auth::id())->where('product_id' , $request->product_id)->first();

        if($cart){
            $cart->update([
                'qty' => $cart->qty + $request->qty,
            ]);
        }else{
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'price' => $price,
                'qty' => $request->qty,
            ]);
        }

       $product->updated(['quntity' => ($product->quntity - $request->qty)]);

        return view('site.cart');
    }

    public function remove_cart($id) 
    {
        dd($id);
        $cart = Cart::findOrFail($id);

        $product = $cart->product;

        $product->updated(['quntity' => ($product->quntity + $cart->qty)]);

        $cart->delete();

        return redirect()->back();

    }
}
