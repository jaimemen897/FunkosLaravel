@php use App\Models\Category; @endphp
@extends('main')

@section('title', 'Editar Category')
@section('content')
    <div class="container">
        <h1>Actualizar Categoría</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            <br/>
        @endif

        <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data"
              id="formEditCat">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $category->id }}">

            <div class="form-group mb-3">
                <label for="name">Nombre</label>
                <input class="form-control" id="name" name="name" type="text" required
                       value="{{ $category->name }}">
            </div>
        </form>

        <button form="formEditCat" class="btn btn-primary" type="submit">Actualizar</button>
        <a class="btn btn-secondary mx-2" href="{{ route('category.index') }}">Volver</a>

    </div>
@endsection
