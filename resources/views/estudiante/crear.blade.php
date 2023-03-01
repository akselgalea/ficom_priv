@extends('layouts.app')
@section('content')

@php
    if(isset($res) && $res['status'] == 400) $estudiante = $res['estudiante'];
@endphp
        
<div class="container card form-container">
    <form method="post" action="{{ route('estudiante.store') }}" id="estudiante.store" class="mt-3 row">
        @csrf
        <h2 class="form-title">Estudiante</h2>
        <div class="form-group mb-3 col-md-3 col-6">
            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
            <input type="text" id="apellido_paterno" name="apellido_paterno" value="{{ old('apellido_paterno') }}" class="form-control @error('apellido_paterno') is-invalid @enderror" autofocus>
                
            @error('apellido_paterno')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-3 col-6">
            <label for="apellido_materno" class="form-label">Apellido Materno</label>
            <input type="text" id="apellido_materno" name="apellido_materno" value="{{ old('apellido_materno') }}" class="form-control @error('apellido_materno') is-invalid @enderror">
                
            @error('apellido_materno')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-6 col-6">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" id="nombres" name="nombres" value="{{ old('nombres') }}" class="form-control @error('nombres') is-invalid @enderror">
                
            @error('nombres')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-4 col-6">
            <label for="run" class="form-label">RUN</label>
            <input type="text" id="run" name="run" value="{{ old('run') }}" placeholder="11111111-1" class="form-control @error('run') is-invalid @enderror">
                
            @error('run')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-4 col-6">
            <label for="nivel" class="form-label">Nivel</label>
            <select id="nivel" name="nivel" class="form-control form-select @error('nivel') is-invalid @enderror">
                <option value="" selected disabled hidden>Selecciona una opción</option>
                @foreach ($cursos as $curso)
                    <option value="{{$curso->id}}" @selected(old('nivel') == $curso->id)>{{$curso->curso . '-' . $curso->paralelo}}</option>
                @endforeach
            </select>

            @error('nivel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-4 col-6">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select id="prioridad" name="prioridad" class="form-control form-select @error('prioridad') is-invalid @enderror">
                <option value="" selected disabled hidden>Selecciona una opción</option>
                <option @selected(old('prioridad') == 'alumno regular') value="alumno regular">Alumno regular</option>
                <option @selected(old('prioridad') == 'nuevo prioritario') value="nuevo prioritario">Nuevo prioritario</option>
                <option @selected(old('prioridad') == 'prioritario') value="prioritario">Prioritario</option>
            </select>

            @error('prioridad')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row mt-3">
            <h2>Apoderado</h2>
            <div class="form-group mb-3 col-6">
                <label for="names" class="form-label">Nombres</label>
                <input type="text" id="names" name="a_nombres" value="{{ old('a_nombres') }}" class="form-control @error('a_nombres') is-invalid @enderror">
                
                @error('a_nombres')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-6">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" id="apellidos" name="a_apellidos" value="{{ old('a_apellidos')}}" class="form-control @error('a_apellidos') is-invalid @enderror">
                
                @error('a_apellidos')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-6">
                <label for="a_telefono" class="form-label">Teléfono</label>
                <input type="text" id="a_telefono" name="a_telefono" value="{{ old('a_telefono') }}" class="form-control @error('a_telefono') is-invalid @enderror">
                
                @error('a_telefono')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-md-6 col-12">
                <label for="a_email" class="form-label">Correo Electrónico</label>
                <input type="email" id="a_email" name="a_email" value="{{ old('a_email') }}" class="form-control @error('a_email') is-invalid @enderror">
                
                @error('a_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-md-6 col-12">
                <label for="a_direccion" class="form-label">Dirección</label>
                <input type="text" id="a_direccion" name="a_direccion" value="{{ old('a_direccion') }}" class="form-control @error('a_direccion') is-invalid @enderror">
                
                @error('a_direccion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <h2>Apoderado suplente</h2>
            <div class="form-group mb-3 col-6">
                <label for="sub_nombres" class="form-label">Nombres</label>
                <input type="text" id="sub_nombres" name="sub_nombres" value="{{ old('sub_nombres') }}" class="form-control @error('sub_nombres') is-invalid @enderror">
                
                @error('sub_nombres')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-6">
                <label for="sub_apellidos" class="form-label">Apellidos</label>
                <input type="text" id="sub_apellidos" name="sub_apellidos" value="{{ old('sub_apellidos') }}" class="form-control @error('sub_apellidos') is-invalid @enderror">
                
                @error('sub_apellidos')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-6">
                <label for="sub_telefono" class="form-label">Teléfono</label>
                <input type="text" id="sub_telefono" name="sub_telefono" value="{{ old('sub_telefono') }}" class="form-control @error('sub_telefono') is-invalid @enderror">
                
                @error('sub_telefono')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-md-6 col-12">
                <label for="sub_email" class="form-label">Correo Electrónico</label>
                <input type="email" id="sub_email" name="sub_email" value="{{ old('sub_email') }}" class="form-control @error('sub_email') is-invalid @enderror">
                
                @error('sub_email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 col-md-6 col-12">
                <label for="sub_direccion" class="form-label">Dirección</label>
                <input type="text" id="sub_direccion" name="sub_direccion" value="{{ old('sub_direccion') }}" class="form-control @error('sub_direccion') is-invalid @enderror">
                
                @error('sub_direccion')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary my-3">Guardar</button>
        </div>
    </form>
</div>
@endsection
