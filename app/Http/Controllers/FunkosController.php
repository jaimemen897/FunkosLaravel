<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Funko;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\alert;

class FunkosController extends Controller
{
    /*FIND ALL*/
    public function index(Request $request)
    {
        $funkos = Funko::search($request->search)->orderBy('id', 'asc')->paginate(3);

        return view('funkos.index')->with('funkos', $funkos);
    }

    public function findAll()
    {
        $funkos = Funko::all();
        if ($funkos) {
            return $funkos->toJson();
        } else {
            return response()->json(['message' => 'Funkos not found.'], 404);
        }
    }

    /*FIND BY ID*/
    public function show($id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            return view('funkos.show')->with('funko', $funko);
        } else {
            flash('Funko no encontrado')->error();
            return redirect()->route('funkos.index');
        }
    }

    public function findById($id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            return $funko->toJson();
        } else {
            return response()->json(['message' => 'Funko not found.'], 404);
        }
    }

    /*CREATE*/
    public function store()
    {
        $categories = Category::all();
        return view('funkos.create')->with('categories', $categories);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:funkos|max:255|min:3|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|integer'
        ], $this->messages());

        if ($validator->fails()) {
            flash('Error al crear el Funko')->error();
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $funko = new Funko();
        $funko->name = $request->name;
        $funko->price = $request->price;
        $funko->stock = $request->stock;
        $funko->image = $funko::$IMAGE_DEFAULT;
        $funko->category_id = $request->category_id;
        $funko->save();
        flash('Funko creado correctamente')->success();
        return redirect()->route('funkos.index');
    }

    /*UPDATE*/
    public function edit($id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            $categories = Category::all();
            return view('funkos.edit')->with('funko', $funko)->with('categories', $categories);
        } else {
            return response()->json(['message' => 'Funko not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            $validator = Validator::make($request->all(), [
                'name' => 'required:funkos|max:255|min:3|string',
                'price' => 'numeric',
                'stock' => 'integer',
                'category_id' => 'integer'
            ], $this->messages());

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }

            $funko->name = $request->name;
            $funko->price = $request->price;
            $funko->stock = $request->stock;
            $funko->category_id = $request->category_id;
            $funko->save();
            flash('Funko actualizado correctamente')->success();
            return redirect()->route('funkos.index');
        } else {
            flash('Funko no encontrado')->error();
            return redirect()->route('funkos.index');
        }
    }

    /*UPDATE IMAGE*/
    public function editImage($id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            return view('funkos.image')->with('funko', $funko);
        } else {
            return response()->json(['message' => 'Funko not found.'], 404);
        }
    }

    public function updateImage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], $this->messages());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        try {
            $funko = Funko::find($id);

            if (!$funko) {
                return response()->json(['message' => 'Funko not found.'], 404);
            }

            if ($funko->image !== Funko::$IMAGE_DEFAULT && Storage::exists($funko->image)) {
                Storage::delete($funko->image);
            }

            $image = $request->file('image');
            $filename= $image->getClientOriginalName();
            $fileToSave = time() . $filename;
            $image->storeAs('public/public/funkos', $fileToSave);
            $funko->image = $fileToSave;

            $funko->save();
            flash('Imagen actualizada correctamente')->success();
            return redirect()->route('funkos.index');
        } catch (Exception $e) {
            flash('Error al actualizar la imagen')->error();
            return redirect()->route('funkos.index');
        }
    }

    /*DELETE*/
    public function destroy($id)
    {
        $funko = Funko::find($id);
        if ($funko) {
            $imagePath = 'public/public/funkos/' . $funko->image;
            if ($funko->image !== Funko::$IMAGE_DEFAULT && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
            $funko->delete();
            flash('Funko eliminado correctamente')->success();
            return redirect()->route('funkos.index');
        } else {
            flash('Funko no encontrado')->error();
            return redirect()->route('funkos.index');
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
            'category_id.required' => 'The category is required.',
            'category_id.integer' => 'The category must be an integer.',
            'image.image' => 'The image must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 2048 kilobytes.'
        ];
    }
}
