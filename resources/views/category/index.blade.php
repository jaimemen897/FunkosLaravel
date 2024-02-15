@php use App\Models\Category; @endphp
@extends('main')

@section('title', 'Category CRUD')

@section('content')
    <div class="container mt-4 mb-5">
        <h1 class="mb-4">Listado de Categorias</h1>

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

        @if ( count($categories ?? []) > 0 )
            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $category->name }}</h5>

                                <div class="d-flex flex-wrap">
                                    <div class="cajaBotones w-100">
                                        <a href="{{ route('categories.show', $category->id) }}"
                                           class="btn btn-primary botonCajaCategory"><i
                                                class="bi bi-eye"></i> Detalles</a>
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                           class="btn btn-secondary botonCajaCategory"><i
                                                class="bi bi-pencil"></i> Editar</a>
                                    </div>
                                    <div class="w-100">
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                              class="w-100">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger botonCajaCategory w-100"
                                                    onclick="return confirm('¿Desea borrar este category?')">
                                                <i class="bi bi-trash"></i> Borrar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="btn btn-success mt-4" href={{ route('categories.store') }}><i class="bi bi-plus"></i> Nuevo
                Category</a>

        @else
            <div class="alert alert-warning" role="alert">
                <p class='mb-0'>
                    <em>No se han encontrado categories</em>
                </p>
            </div>
        @endif

        <div class="pagination-container mt-4 d-flex justify-content-center">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
