@extends('layouts.app')
@section('content')

@php
    $hAT = $estudiante->hasApoderadoTitular();  //hasApoderadoTitular
    $hAS = $estudiante->hasApoderadoSuplente(); //hasApoderadoSuplente
@endphp

<div class="container">
    <div class="buttons mb-4">
        <a href="{{ route('estudiante.pagos', $estudiante->id) }}" class="btn btn-primary">Ver historial de pago</a>
        <a href="{{ route('estudiante.beca.edit', $estudiante->id) }}" class="btn btn-primary">Administrar beca</a>
    </div>

    <form method="POST" action="{{route('estudiante.update', $estudiante->id)}}" class="mt-3 row">
        @csrf
        <h2>Estudiante</h2>
        <div class="form-group mb-3 col-md-4 col-6">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" name="apellidos" id="apellidos"  class="form-control @error('apellidos') is-invalid @enderror" value="{{old('apellidos') ? old('apellidos') : $estudiante->apellidos}}" disabled>

            @error('apellidos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-4 col-6">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" name="nombres" id="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{old('nombres') ? old('nombres') : $estudiante->nombres}}" disabled>

            @error('nombres')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-4 col-6">
            <label for="run" class="form-label">RUN</label>
            <input type="text" name="run" id="run" class="form-control @error('run') is-invalid @enderror" value="{{old('run') ? old('run') : $estudiante->rut . '-' . $estudiante->dv}}" disabled>

            @error('run')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-4 col-6">
            <label for="email_institucional" class="form-label">Correo Institucional</label>
            <input type="email" name="email_institucional" id="email_institucional" class="form-control @error('email_institucional') is-invalid @enderror" value="{{old('email_institucional') ? old('email_institucional') : $estudiante->email_institucional}}" disabled>

            @error('email_institucional')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-md-4 col-6">
            <label for="nivel" class="form-label">Nivel</label>
            <select id="nivel" name="nivel" id="nivel" class="form-control form-select @error('nivel') is-invalid @enderror" disabled>
                @foreach ($cursos as $curso)
                    <option value="{{$curso->id}}" @selected($estudiante->curso_id == $curso->id)>{{$curso->curso . '-' . $curso->paralelo}}</option>
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
            <select name="prioridad" id="prioridad" class="form-control form-select @error('prioridad') is-invalid @enderror" disabled>
                <option value="alumno regular" @selected($estudiante->prioridad == "alumno regular")>Alumno regular</option>
                <option value="nuevo prioritario" @selected($estudiante->prioridad == "nuevo prioritario")>Nuevo prioritario</option>
                <option value="prioritario" @selected($estudiante->prioridad == "prioritario")>Prioritario</option>
            </select>

            @error('prioridad')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="apoderado-title mt-3 mb-1">
            <h2>Apoderado</h2>
            @if($hAT)
            <div>
                <button type="button" class="btn btn-sm btn-danger del" onclick="deleteSubmit('deleteApoderado')">Eliminar</button>
            </div>
            @endif
        </div>

        <div class="form-group mb-3 col-6 col-md-6">
            <label for="a_nombres" class="form-label">Nombres</label>
            <input type="text" id="a_nombres" name="a_nombres" class="form-control @error('a_nombres') is-invalid @enderror" 
                value="{{old('a_nombres') ? old('a_nombres') : ($hAT ? $estudiante->apoderado_titular->nombres : '')}}" disabled
            >

            @error('a_nombres')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-6">
            <label for="a_apellidos" class="form-label">Apellidos</label>
            <input type="text" id="a_apellidos" name="a_apellidos" class="form-control @error('a_apellidos') is-invalid @enderror" 
                value="{{old('a_apellidos') ? old('a_apellidos') : ($hAT ? $estudiante->apoderado_titular->apellidos : '')}}" disabled
            >

            @error('a_apellidos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-2">
            <label for="a_telefono" class="form-label">Teléfono</label>
            <input type="text" id="a_telefono" name="a_telefono" class="form-control @error('a_telefono') is-invalid @enderror" 
                value="{{old('a_telefono') ? old('a_telefono') : ($hAT ? $estudiante->apoderado_titular->telefono : '')}}" disabled
            >

            @error('a_telefono')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-5">
            <label for="a_email" class="form-label">Correo Electrónico</label>
            <input type="email" id="a_email" name="a_email" class="form-control @error('a_email') is-invalid @enderror" 
                value="{{old('a_email') ? old('a_email') : ($hAT ? $estudiante->apoderado_titular->email : '')}}" disabled
            >

            @error('a_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-5">
            <label for="a_direccion" class="form-label">Dirección</label>
            <input type="text" id="a_direccion" name="a_direccion" class="form-control @error('a_direccion') is-invalid @enderror" 
                value="{{old('a_direccion') ? old('a_direccion') : ($hAT ? $estudiante->apoderado_titular->direccion : '')}}" disabled
            >

            @error('a_direccion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="apoderado-title mt-3 mb-1">
            <h2>Apoderado suplente</h2>
            @if($hAS)
            <div>
                <button type="button" class="btn btn-sm btn-danger del" onclick="deleteSubmit('deleteApoderadoSuplente')">Eliminar</button>
            </div>
            @endif
        </div>
        <div class="form-group mb-3 col-6">
            <label for="sub_nombres" class="form-label">Nombres</label>
            <input type="text" id="sub_nombres" name="sub_nombres" class="form-control @error('sub_nombres') is-invalid @enderror" 
                value="{{old('sub_nombres') ? old('sub_nombres') : ($hAS ? $estudiante->apoderado_suplente->nombres : '')}}" disabled
            >

            @error('sub_nombres')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6">
            <label for="sub_apellidos" class="form-label">Apellidos</label>
            <input type="text" id="sub_apellidos" name="sub_apellidos" class="form-control @error('sub_apellidos') is-invalid @enderror" 
                value="{{old('sub_apellidos') ? old('sub_apellidos') : ($hAS ? $estudiante->apoderado_suplente->apellidos : '')}}" disabled
            >

            @error('sub_apellidos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-2">
            <label for="sub_telefono" class="form-label">Teléfono</label>
            <input type="text" id="sub_telefono" name="sub_telefono" class="form-control @error('sub_telefono') is-invalid @enderror" 
                value="{{old('sub_telefono') ? old('sub_telefono') : ($hAS ? $estudiante->apoderado_suplente->telefono : '')}}" disabled
            >

            @error('sub_telefono')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-5">
            <label for="sub_email" class="form-label">Correo Electrónico</label>
            <input type="email" id="sub_email" name="sub_email" class="form-control @error('sub_email') is-invalid @enderror" 
                value="{{old('sub_email') ? old('sub_email') : ($hAS ? $estudiante->apoderado_suplente->email : '')}}" disabled
            >

            @error('sub_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-5">
            <label for="sub_direccion" class="form-label">Dirección</label>
            <input type="text" id="sub_direccion" name="sub_direccion" class="form-control @error('sub_direccion') is-invalid @enderror" 
                value="{{old('sub_direccion') ? old('sub_direccion') : ($hAS ? $estudiante->apoderado_suplente->direccion : '')}}" disabled
            >

            @error('sub_direccion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <div class="buttons">
            <button type="button" id="btn-editar" class="btn btn-secondary" onclick="editar()">Editar</button>
            <button type="button" id="btn-cancelar" class="btn btn-danger" onclick="cancelEditar()" hidden>Cancelar</button>
            <button type="submit" id="btn-enviar" class="btn btn-primary" hidden>Guardar</button>
        </div>
    </form>

    @if($hAT)
    <form method="post" action="{{route('estudiante.apoderado.remove', ['id' => $estudiante->id, 'apoderado' => $estudiante->apoderado_titular->id])}}" id="deleteApoderado">
        @method('delete')
        @csrf
    </form>
    @endif

    @if($hAS)
    <form method="post" action="{{route('estudiante.apoderado.remove', ['id' => $estudiante->id, 'apoderado' => $estudiante->apoderado_suplente->id])}}" id="deleteApoderadoSuplente">
        @method('delete')
        @csrf
    </form>
    @endif
</div>
@endsection

@push('scripts')
    <script>
        const btneditar = document.getElementById('btn-editar');
        const cancelar = document.getElementById('btn-cancelar');
        const enviar = document.getElementById('btn-enviar');
        const deleteBtns = document.getElementsByClassName('del');
    
        for(let btn of deleteBtns) btn.hidden = true;

        //Estudiante
        const apellidos = document.getElementById('apellidos');
        const nombres = document.getElementById('nombres');
        const run = document.getElementById('run');
        const email_institucional = document.getElementById('email_institucional');
        const nivel = document.getElementById('nivel');
        const prioridad = document.getElementById('prioridad');
        
        //Apoderado
        const a_nombres = document.getElementById('a_nombres');
        const a_apellidos = document.getElementById('a_apellidos');
        const a_telefono = document.getElementById('a_telefono');
        const a_email = document.getElementById('a_email');
        const a_direccion = document.getElementById('a_direccion');
        
        //Apoderado suplente
        const sub_nombres = document.getElementById('sub_nombres');
        const sub_apellidos = document.getElementById('sub_apellidos');
        const sub_telefono = document.getElementById('sub_telefono');
        const sub_email = document.getElementById('sub_email');
        const sub_direccion = document.getElementById('sub_direccion');
        
        function editar() {
            for(let btn of deleteBtns) btn.hidden = false;
            btneditar.hidden = true;
            cancelar.hidden = false;
            enviar.hidden = false;
            enableInput();
        }

        function cancelEditar() {
            for(let btn of deleteBtns) btn.hidden = true;
            btneditar.hidden = false;
            cancelar.hidden = true;
            enviar.hidden = true;
            disableInput();
        }

        function enableInput() {
            apellidos.disabled = false;
            nombres.disabled = false;
            run.disabled = false;
            email_institucional.disabled = false;
            nivel.disabled = false;
            prioridad.disabled = false;
            
            a_nombres.disabled = false;
            a_apellidos.disabled = false;
            a_telefono.disabled = false;
            a_email.disabled = false;
            a_direccion.disabled = false;
            
            sub_nombres.disabled = false;
            sub_apellidos.disabled = false;
            sub_telefono.disabled = false;
            sub_email.disabled = false;
            sub_direccion.disabled = false;
        }

        function disableInput() {
            apellidos.disabled = true;
            nombres.disabled = true;
            run.disabled = true;
            email_institucional.disabled = true;
            nivel.disabled = true;
            prioridad.disabled = true;

            a_nombres.disabled = true;
            a_apellidos.disabled = true;
            a_telefono.disabled = true;
            a_email.disabled = true;
            a_direccion.disabled = true;

            sub_nombres.disabled = true;
            sub_apellidos.disabled = true;
            sub_telefono.disabled = true;
            sub_email.disabled = true;
            sub_direccion.disabled = true;
        }
    </script>

    @if($errors->any())
    <script type="text/javascript">
        editar();
    </script>
    @endif

    <script src="{{ asset('js/components/delete.js') }}"></script>
@endpush