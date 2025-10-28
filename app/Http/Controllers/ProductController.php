<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }  

    

    public function getManageProduct(){
        $product = Product::get();
        return view('admin.product.mngProduct', compact('product'));
    }

    public function addProduct(Request $request)
    {
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->detail = $request->input('detail');
        $product->cost = $request->input('cost');
        $product->cat_id = $request->input('cat_id');
        $product->photo = $photoPath;
        $product->user_id = auth()->id();
        $product->save();

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function editProduct(int $id){
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function updateProduct(Request $request)
    {
        $product = Product::findOrFail($request->id);
        if ($request->hasFile('photo')) {
            if ($product->photo && Storage::disk('public')->exists($product->photo)) {
                Storage::disk('public')->delete($product->photo);
            }
            
            $photoPath = $request->file('photo')->store('photos', 'public');
            $product->photo = $photoPath;
        }
        $product->update([
            'name' => $request->name,
            'detail' => $request->detail,
            'cost' => $request->cost,
            'cat_id' => $request->cat_id,
        ]);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(int $id)
    {
        $product = Product::findOrFail($id);
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    
}
