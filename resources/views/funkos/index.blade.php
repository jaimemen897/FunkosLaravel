@php use App\Models\Funko; @endphp
@extends('main')

@section('title', 'Funkos CRUD')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
        </div>
        <br/>
    @endif
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
                                     src="{{ asset('storage/funkos/' . $funko->image) }}" width="406" height="406">
                            @else
                                <img alt="Imagen por defecto" src="{{ Funko::$IMAGE_DEFAULT }}" width="406" height="406">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $funko->name }}</h5>
                                <p class="card-text">Precio: {{ $funko->price }} - Stock: {{ $funko->stock }}</p>

                                <div class="d-flex flex-wrap">
                                    @if(auth()->user() && auth()->user()->role == 'admin')
                                        <div class="cajaBotones w-100">
                                            <form action="{{ route('funkos.destroy', $funko->id) }}" method="POST"
                                                  class="formBorrar">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger botonCajaFunko w-100"
                                                        onclick="return confirm('¿Desea borrar este funko?')">
                                                    <i class="bi bi-trash"></i> Borrar
                                                </button>
                                            </form>
                                            <a href="{{ route('funkos.edit', $funko->id) }}"
                                               class="btn btn-secondary botonCajaFunko">
                                                <i class="bi bi-pencil"></i> Editar
                                            </a>
                                            <a href="{{ route('funkos.editImage', $funko->id) }}"
                                               class="btn btn-info botonCajaFunko">
                                                <i class="bi bi-image"></i> Imagen
                                            </a>
                                        </div>
                                    @endif
                                    <div class="w-100">
                                        <a href="{{ route('funkos.show', $funko->id) }}"
                                           class="btn btn-primary botonCajaFunko w-100">
                                            <i class="bi bi-eye"></i> Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if(auth()->user() && auth()->user()->role == 'admin')
                <a class="btn btn-success mt-4" href={{ route('funkos.store') }}><i class="bi bi-plus"></i> Nuevo Funko</a>
            @endif
        @else
            <div class="alert alert-warning" role="alert">
                <p class='mb-0'>
                    No se encontraron funkos
                </p>
            </div>
        @endif

        <div class="pagination-container mt-4 d-flex justify-content-center">
            {{ $funkos->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
