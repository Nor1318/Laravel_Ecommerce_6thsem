<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SiteController extends Controller
{
    public function getHome(){
        return view('home1');
    }
    public function getServices(){
        return view('services');
    }

    public function allProducts(){
        return view('allProducts');
    }

    public function getProducts() {
        $products = Product::orderBy('created_at','desc')->get();
        $products->transform(function ($product) {
            $product->photo_url = asset('storage/' . $product->photo);
            return $product;
        });
    
        return response()->json($products);
    }

    public function getProduct(int $id){
        $product = Product::findOrFail($id);
        $category = Category::findOrFail($product->cat_id);
        return view('product', [
            'product' => $product,
            'category' => $category,
        ]);
    }
}
