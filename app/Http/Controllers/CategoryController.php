<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = new Category;
        $category = $category->get();

        return view('Admin.add_category', [
            'category' => $category,
        ]);

    }

    public function getCategories(Request $request)
    {
        $term = $request->input('term');
        $categories = Category::where('name', 'like', '%'.$term.'%')->pluck('name');

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:categories',
        ]);

        $category = new Category;
        $category->name = $validatedData['name'];
        $category->description = $request->input('description');

        $category->save();

        return redirect()->route('add.category')->with('message', 'Category added successfully');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:categories,name,'.$id,
        ]);

        $category = Category::findOrFail($id);
        $category->name = $validatedData['name'];
        $category->description = $request->input('description');

        $category->save();

        return redirect()->route('add.category')->with('message', 'Category updated successfully');
    }
}
