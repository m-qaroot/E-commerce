<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index (){

        $main_categories = Category::whereNull('parent_id')->take(11)->get();
        $latest_products = Product::orderByDesc('created_at')->limit(3)->get();
        return view('site.index' , compact('main_categories' , 'latest_products'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        return view('site.category' , compact('category'));
    }

    public function product($id){
        $product = Product::findOrFail($id);
        $products = Product::with('category')->get();
        return view('site.prdouctDetailes' , compact('product' , 'products'));
    }
}
