<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if ($categories) {
            return $categories->toJson();
        } else {
            return response()->json(['message' => 'Categories not found.'], 404);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $category->toJson();
        } else {
            return response()->json(['message' => 'Category not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255|min:3|string'
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return response()->json(['message' => 'Category created successfully.'], 201);
    }

    public function edit(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categories|max:255|min:3|string'
            ], $this->messages());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $category->name = $request->name;
            $category->save();
            return response()->json(['message' => 'Category updated successfully.']);
        } else {
            return response()->json(['message' => 'Category not found.'], 404);
        }
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

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.min' => 'The name must be at least 3 characters.',
            'name.string' => 'The name must be a string.'
        ];
    }
}
