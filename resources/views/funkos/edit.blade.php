@php use App\Models\Funko; @endphp
@extends('main')

@section('title', 'Editar Funko')

@section('content')
    <div class="container">
        <h1>Actualizar Funko</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route("funkos.update", $funko->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input class="form-control" id="name" name="name" type="text" required value="{{$funko->name}}">
            </div>
            <div class="form-group">
                <label for="price">Precio:</label>
                <input class="form-control" id="price" min="0.0" name="price" step="0.01" type="number" required
                       value="{{$funko->price}}">
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input class="form-control" id="stock" min="0" name="stock" type="number" required
                       value="{{$funko->stock}}">
            </div>
            <div class="form-group mb-3">
                <label for="category_id">Categoría:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option>Seleccione una categoría</option>
                    @foreach($categories as $category)
                        <option @if($funko->category->id == $category->id) selected
                                @endif value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary" type="submit">Actualizar</button>
            <a class="btn btn-secondary mx-2" href="{{ route('funkos.index') }}">Volver</a>
        </form>
    </div>
@endsection
