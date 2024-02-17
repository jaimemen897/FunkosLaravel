@php use App\Models\Funko; @endphp

@extends('main')

@section('title', 'Detalles Funko')

@section('content')
    <div class="container">
        <h1>Detalles del Funko</h1>
        <dl class="row mt-4">
            <div class="col-sm-6">
                <dt class="col-sm-2">ID:</dt>
                <dd class="col-sm-10">{{ $funko->id }}</dd>

                <dt class="col-sm-2">Nombre:</dt>
                <dd class="col-sm-10">{{ $funko->name }}</dd>

                <dt class="col-sm-2">Precio:</dt>
                <dd class="col-sm-10">{{ $funko->price }}</dd>

                <dt class="col-sm-2">Stock:</dt>
                <dd class="col-sm-10">{{ $funko->stock }}</dd>

                <dt class="col-sm-2">Categoría:</dt>
                <dd class="col-sm-10">{{ $funko->category->name }}</dd>


                <div class="mt-3">
                    <a class="btn btn-primary" href="{{ route('funkos.index') }}">Volver</a>
                </div>
            </div>
            <div class="col-sm-6">
                <dt class="col-sm-2">Imagen:</dt>
                <dd class="col-sm-10">
                    @if($funko->image != Funko::$IMAGE_DEFAULT)
                        <img alt="Imagen del funko" class="img-fluid" src="{{ asset('storage/funkos/' . $funko->image) }}" width="280" height="280">
                    @else
                        <img alt="Imagen por defecto" class="img-fluid" src="{{ Funko::$IMAGE_DEFAULT }}" width="280" height="280">
                    @endif
                </dd>
            </div>
        </dl>

    </div>
@endsection
