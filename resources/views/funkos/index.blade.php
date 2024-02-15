@php use App\Models\Funko; @endphp
@extends('main')

@section('title', 'Funkos CRUD')

@section('content')
    <div class="container mt-4 mb-5">
        <h1 class="mb-4">Listado de Funkos</h1>

        <form action="{{ route('funkos.index') }}" class="mb-3" method="get">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" id="search" name="search" placeholder="Nombre">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-search" type="submit"><i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>

        @if ( count($funkos ?? []) > 0 )
            <div class="row">
                @foreach ($funkos as $funko)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if($funko->image != Funko::$IMAGE_DEFAULT)
                                <img class="card-img-top" alt="Imagen del funko"
                                     src="{{ asset('storage/public/funkos/' . $funko->image) }}">
                            @else
                                <img alt="Imagen por defecto" src="{{ Funko::$IMAGE_DEFAULT }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $funko->name }}</h5>
                                <p class="card-text">Precio: {{ $funko->price }} - Stock: {{ $funko->stock }}</p>

                                <div class="d-flex flex-wrap">
                                    <div class="cajaBotones w-100">
                                        <a href="{{ route('funkos.show', $funko->id) }}" class="btn btn-primary botonCajaFunko"><i
                                                class="bi bi-eye"></i> Detalles</a>
                                        <a href="{{ route('funkos.edit', $funko->id) }}" class="btn btn-secondary botonCajaFunko"><i
                                                class="bi bi-pencil"></i> Editar</a>
                                        <a href="{{ route('funkos.editImage', $funko->id) }}" class="btn btn-info botonCajaFunko"><i
                                                class="bi bi-image"></i> Imagen</a>
                                    </div>
                                    <div class="w-100">
                                        <form action="{{ route('funkos.destroy', $funko->id) }}" method="POST" class="w-100">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger botonCajaFunko w-100"
                                                    onclick="return confirm('¿Desea borrar este funko?')">
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
            <a class="btn btn-success mt-4" href={{ route('funkos.store') }}><i class="bi bi-plus"></i> Nuevo Funko</a>

        @else
            <div class="alert alert-warning" role="alert">
                <p class='mb-0'>
                    <em>No se han encontrado funkos</em>
                </p>
            </div>
        @endif

        <div class="pagination-container mt-4 d-flex justify-content-center">
            {{ $funkos->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
