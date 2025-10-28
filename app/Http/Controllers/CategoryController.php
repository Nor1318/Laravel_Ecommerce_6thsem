<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }  

    public function getManageCategory(){
        $categories = Category::get();
        return view('admin.category.mngCategory', compact('categories'));
    }

    public function getCategoryList(){
        $category = Category::get();
        return response()->json($category);
    }

    public function addCategory(Request $request){
        $title = $request->input('title');
        $details = $request->input('details');

        $category = new Category();
        $category->title = $title;
        $category->details = $details;

        $category->save();
        return redirect()->back()->with('success','Category created successfully.');
    }

    public function editCategory(int $id){
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function updateCategory(Request $request){
        $category = Category::findOrFail($request->id);
        $category->update([
            'title' => $request->title,
            'details' => $request->details,
        ]);
 
        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function deleteCategory($id){
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
    public function index()
    {
        
        $categories = Category::all(); 

    
        return view('your-view-name', compact('categories'));
    }
}
