@php use App\Models\Category; @endphp
@extends('main')

@section('title', 'Category CRUD')
@section('content')

    <div class="container py-5 mb-5">
        <h1 class="mb-4">Listado de Funkos</h1>

        <form action="{{ route('category.index') }}" class="mb-3" method="get">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" id="search" name="search" placeholder="Nombre">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-search" type="submit"><i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>


        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Eliminada</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @if ( count($categories ?? []) > 0 )
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->is_deleted ? 'Sí' : 'No' }}</td>
                        <td>
                            <a class="btn btn-secondary btn-sm"
                               href="{{ route('category.edit', $category->id) }}">Editar</a>
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">No se han encontrado categorías</td>
                </tr>
            @endif

            </tbody>
        </table>
        <a class="btn btn-success" href="{{ route('category.create') }}">Nueva Categoría</a>
    </div>

@endsection
