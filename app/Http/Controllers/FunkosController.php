<?php

namespace App\Http\Controllers;

use App\Models\Funko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FunkosController extends Controller
{
    public function index()
    {
        $funkos = Funko::all();
        if ($funkos) {
            return $funkos->toJson();
        } else {
            return response()->json(['message' => 'Funkos not found.'], 404);
        }
    }

    public function show($id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            return $funko->toJson();
        } else {
            return response()->json(['message' => 'Funko not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:funkos|max:255|min:3|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'image' => 'required',
            'category_id' => 'required|integer'
        ], $this->messages());

        if ($validator->fails()) {
            /*return redirect()->back()->withErrors($validator)->withInput();*/
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $funko = new Funko();
        $funko->name = $request->name;
        $funko->price = $request->price;
        $funko->stock = $request->stock;
        $funko->image = $request->image;
        $funko->category_id = $request->category_id;
        $funko->save();
        return response()->json(['message' => 'Funko created successfully.'], 201);
    }

    public function edit(Request $request, $id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:funkos|max:255|min:3|string',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'image' => 'required',
                'category_id' => 'required|integer'
            ], $this->messages());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $funko->name = $request->name;
            $funko->price = $request->price;
            $funko->stock = $request->stock;
            $funko->image = $request->image;
            $funko->category_id = $request->category_id;
            $funko->save();
            return response()->json(['message' => 'Funko updated successfully.']);
        } else {
            return response()->json(['message' => 'Funko not found.'], 404);
        }
    }

    public function destroy($id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            $funko->delete();
            return response()->json(['message' => 'Funko deleted successfully.']);
        } else {
            return response()->json(['message' => 'Funko not found.'], 404);
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'name.unique' => 'The name is already in use.',
            'name.max' => 'The name is too long.',
            'name.min' => 'The name is too short.',
            'name.string' => 'The name must be a string.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.01.',
            'stock.required' => 'The stock is required.',
            'stock.integer' => 'The stock must be an integer.',
            'stock.min' => 'The stock must be at least 0.',
            'image.required' => 'The image is required.',
            'category_id.required' => 'The category is required.',
            'category_id.integer' => 'The category must be an integer.'
        ];
    }
}
