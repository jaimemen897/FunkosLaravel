<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if ($categories) {
            return $categories->toJson();
        } else {
            return response()->json([
                'message' => 'Categories not found.'
            ], 404);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $category->toJson();
        } else {
            return response()->json([
                'message' => 'Category not found.'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $existingCategory = Category::where('name', $request->name)->first();
        if ($existingCategory) {
            return response()->json([
                'message' => 'Category already exists.'
            ], 400);
        }
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return response()->json([
            'message' => 'Category created successfully.'
        ], 201);
    }

    public function edit(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found.'
            ], 404);
        }
        $existingCategory = Category::where('name', $request->name)->first();
        if ($existingCategory) {
            return response()->json([
                'message' => 'Category already exists.'
            ], 400);
        }
        $category->name = $request->name;
        $category->save();
        return $category->toJson();
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category){
            $category->delete();
            return response()->json([
                'message' => 'Category deleted successfully.'
            ], 204);
        } else {
            return response()->json([
                'message' => 'Category not found.'
            ], 404);
        }
    }
}
