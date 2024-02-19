@php use App\Models\Funko; @endphp

@extends('main')

@section('title', 'Editar Imagen de Funko')

@section('content')
    <div class="container">
        <h1>Editar Imagen de Funko</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <dl class="row">
            <div class="col-sm-6">
                <dt class="col-sm-2">ID:</dt>
                <dd class="col-sm-10">{{$funko->id}}</dd>
                <dt class="col-sm-2">Nombre:</dt>
                <dd class="col-sm-10">{{$funko->name}}</dd>
                <dt class="col-sm-2">Precio:</dt>
                <dd class="col-sm-10">{{$funko->price}}</dd>
                <dt class="col-sm-2">Stock:</dt>
                <dd class="col-sm-10">{{$funko->stock}}</dd>
                <form action="{{ route("funkos.updateImage", $funko->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group mb-3">
                        <label for="image"><strong>Imagen:</strong></label> <br>
                        <input accept="image/*" class="form-control-file" id="image" name="image" required type="file">
                        <small class="text-danger"></small>
                    </div>

                    <button class="btn btn-primary" type="submit">Actualizar</button>
                    <a class="btn btn-secondary mx-2" href="{{ route('funkos.index') }}">Volver</a>
                </form>
            </div>
            <div class="col-sm-6">
                <dd class="col-sm-10">
                    @if($funko->image != Funko::$IMAGE_DEFAULT)
                        <img alt="Imagen del funko" class="img-fluid" src="{{ asset('storage/funkos/' . $funko->image) }}"
                             width="300" height="300">
                    @else
                        <img alt="Imagen por defecto" class="img-fluid" src="{{ Funko::$IMAGE_DEFAULT }}" width="300"
                             height="300">
                    @endif
                </dd>
            </div>
        </dl>
    </div>
@endsection
