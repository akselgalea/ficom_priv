@extends('layouts.app')
@section('content')
<div class="container card form-container">
    <form method="post" action="{{ route('curso.update', $curso->id) }}" id="formCurso" class="mt-3 row">
        @csrf
        <h2 class="form-title">{{ $curso->curso . '-' . $curso->paralelo }}</h2>
        
        <div class="form-group mb-3 col-12">
            <label class="form-label" for="arancel">Arancel</label>
            <input type="number" class="form-control @error('arancel') is-invalid @enderror" id="arancel" name="arancel" value="{{old('arancel') ? old('arancel') : $curso->arancel}}" />
            
            @error('arancel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="buttons mb-3">
            <button type="submit" id="btn-enviar" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
@endsection