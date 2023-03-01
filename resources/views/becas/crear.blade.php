@extends('layouts.app')
@section('content')

<div class="container card form-container">
    <form method="post" action="{{ route('beca.store') }}" id="formBeca" class="mt-3 row">
        @csrf
        <h2 class="form-title">Beca</h2>
        
        <div class="form-group mb-3 col-6">
            <label class="form-label" for="nombre">Nombre</label>
            <input class="form-control @error('nombre') is-invalid @enderror" type="text" name="nombre" value="{{old('nombre')}}">

            @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3 col-6">
            <label class="form-label" for="descuento">% Descuento</label>
            <input class="form-control @error('descuento') is-invalid @enderror" type="number" name="descuento" value="{{old('descuento')}}" min="1" max="100">

            @error('descuento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3 col-12">
            <label class="form-label" for="descripcion">Descripción</label>
            <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion">{{old('descripcion')}}</textarea>

            @error('descripcion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary my-3">Guardar</button>
        </div>
    </form>
@endsection