@extends('layouts.app')
@section('content')

<div class="container card">
    <div class="row">
        <h2 class="mt-3">Información del estudiante</h2>
        <div class="form-group mb-3 col-4">
            <label for="monto_mensual" class="form-label">Estudiante</label>
            <p class="form-control">{{ $estudiante->nombres . ' ' . $estudiante->apellidos }}</p>
        </div>
        
        <div class="form-group mb-3 col-4">
            <label for="monto_mensual" class="form-label">Curso</label>
            <p class="form-control">{{ $estudiante->curso->curso . '-' . $estudiante->curso->paralelo }}</p>
        </div>
        
        <div class="form-group mb-3 col-4">
            <label for="monto_mensual" class="form-label">Prioridad</label>
            <p class="form-control flc">{{ $estudiante->prioridad }}</p>
        </div>

        <div class="form-group mb-3 col-4">
            <label for="monto_mensual" class="form-label">Beca</label>
            <p class="form-control">{{ !is_null($estudiante->beca) ? $estudiante->beca->nombre : 'Sin asignar' }}</p>
        </div>

        <div class="buttons mb-3">
            <form action="{{route('estudiante.beca.delete', $estudiante->id)}}" method="post">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger" @disabled(!$estudiante->beca)>Remover beca</button>
            </form>
        </div>
    </div>

    <div class="row my-3">
        <h2>Asignar beca</h2>
        @foreach($becas as $beca)
        <div class="col-4 mb-3">
            <div class="card beca">
                <div>
                    <div class="nombre">{{ $beca->nombre }}</div>
                    <div class="descuento"><b>Descuento:</b> {{ $beca->descuento }}%</div>
                    <div class="descripcion"><b>Descripción:</b> {{ $beca->descripcion }}</div>
                </div>

                <div class="buttons mt-2">
                    <form action="{{route('estudiante.beca.update', $estudiante->id)}}" method="post">
                        @csrf
                        <input type="hidden" name="beca_id" value="{{$beca->id}}">
                        <button type="submit" class="btn btn-primary" @disabled(!is_null($estudiante->beca) && $estudiante->beca->id == $beca->id)>Asignar beca</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection