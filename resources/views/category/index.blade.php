@php use App\Models\Category; @endphp
@extends('main')

@section('title', 'Category CRUD')
@section('content')

    <div class="container py-5 mb-5">
        <h1 class="mb-4">Listado de Categorías</h1>

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
                        <td>
                            @if($category->is_deleted == 1)
                                <span class="badge bg-danger">Desactivada</span>
                            @else
                                <span class="badge bg-success">Activa</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm"
                               href="{{ route('category.edit', $category->id) }}">Editar</a>
                            <form action="{{ route('category.active', $category->id) }}" method="POST"
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas activar esta categoría?');">
                                    Activar
                                </button>
                            </form>
                            <form action="{{ route('category.deactivate', $category->id) }}" method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas desactivar esta categoría?');">
                                    Desactivar
                                </button>
                            </form>
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        {{ $category->hasFunkos() ? 'disabled' : '' }}
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
        <a class="btn btn-success" href="{{ route('category.create') }}"><i class="bi bi-plus"></i> Nueva Categoría</a>
    </div>

@endsection
