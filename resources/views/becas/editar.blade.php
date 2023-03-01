@extends('layouts.app')
@section('content')
@php if(session('res') && session('res')['status'] == 400) $beca = session('res')['beca']; @endphp
<div class="container card form-container">
    <form method="post" action="{{ route('beca.update', $beca['id']) }}" id="formBeca" class="mt-3 row">
        @csrf
        <h2 class="form-title">Beca</h2>
        
        <div class="form-group mb-3 col-6">
            <label class="form-label" for="nombre">Nombre</label>
            <input class="form-control @error('nombre') is-invalid @enderror" type="text" id="nombre" name="nombre" value="{{old('nombre') ? old('nombre') : $beca['nombre']}}">

            @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3 col-6">
            <label class="form-label" for="descuento">% Descuento</label>
            <input class="form-control @error('descuento') is-invalid @enderror" type="number" id="descuento" name="descuento" value="{{old('descuento') ? old('descuento') : $beca['descuento']}}" min="0" max="100">

            @error('descuento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-3 col-12">
            <label class="form-label" for="descripcion">Descripción</label>
            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion">{{old('descripcion') ? old('descripcion') : $beca['descripcion']}}</textarea>

            @error('descripcion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="buttons mb-3">
            <button type="submit" id="btn-enviar" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" onclick="deleteSubmit()">Eliminar</button>
        </div>
    </form>
    <form method="post" action="{{route('beca.delete', ['id' => $beca->id])}}" id="deleteForm">
        @method('delete')
        @csrf
    </form>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/components/delete.js') }}"></script>
@endpush