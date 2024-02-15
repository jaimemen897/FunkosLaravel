<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::search($request->search)->orderBy('name', 'asc')->paginate(5);

        return view('category.index')->with('categories', $categories);
    }

    public function findAll()
    {
        $categories = Category::all();
        if ($categories) {
            return $categories->toJson();
        } else {
            flash('No se encontraron categorías')->error();
            return redirect()->route('category.index');
        }
    }

    public function show($id)
    {
        $category = Category::find($id);
        if ($category) {
            return view('category.show')->with('category', $category);
        } else {
            flash('Categoría no encontrada')->error();
            return redirect()->route('category.index');
        }
    }

    public function findById($id)
    {
        $category = Category::find($id);
        if ($category) {
            return $category->toJson();
        } else {
            flash('Categoría no encontrada')->error();
            return redirect()->route('category.index');
        }
    }

    public function store()
    {
        return view('category.create');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|max:255|min:3|string'
        ], $this->messages());

        if ($validator->fails()) {
            flash('Error al crear la categoría')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = new Category();
        $category->name = $request->name;
        $category->is_deleted = false;
        $category->save();
        flash('Categoría creada correctamente')->success();
        return response()->json(['message' => 'Category created successfully.'], 201);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if ($category) {
            return view('category.edit')->with('category', $category);
        } else {
            flash('Category no encontrado')->error();
            return redirect()->route('category.index');
        }
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:categories|max:255|min:3|string'
            ], $this->messages());

            if ($validator->fails()) {
                flash('Error al actualizar la categoría')->error();
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $category->name = $request->name;
            $category->is_deleted = false;
            $category->save();
            flash('Categoría actualizada correctamente')->success();
            return redirect()->route('category.index');
        } else {
            flash('Category no encontrado')->error();
            return redirect()->route('category.index');
        }
    }

    public function active($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->is_deleted = false;
            $category->save();
            flash('Categoría activada correctamente')->success();
            return redirect()->route('category.index');
        } else {
            flash('Category no encontrado')->error();
            return redirect()->route('category.index');
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->is_deleted = true;
            $category->save();
            flash('Categoría eliminada correctamente')->success();
            return redirect()->route('category.index');
        } else {
            flash('Category no encontrado')->error();
            return redirect()->route('category.index');
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
