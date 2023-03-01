@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-3">Cursos</h2>
        
        {{-- @if(Auth::user()->hasAnyRole('contabilidad', 'admin'))
            <div class="buttons">
                <a href="{{ route('curso.create') }}" class="btn btn-primary">Nuevo curso</a>    
            </div>
        @endif --}}

        <div class="row my-3">
            @foreach($cursos as $curso)
            <div class="col-4 mb-3">
                <div class="card curso">
                    <div>
                        <div class="nombre">{{ $curso->curso . '-' . $curso->paralelo }}</div>
                        <div class="arancel"><b>Arancel:</b> {{ toCLP($curso->arancel) }}</div>
                        <div class="cantidad"><b>Cantidad estudiantes:</b> {{ $curso->estudiantes->count() }}</div>
                    </div>

                    <div class="buttons mt-2">
                        <a href="{{route('curso.show', $curso->id)}}" class="btn btn-primary">Ver</a>
                        @if(Auth::user()->hasAnyRole('admin', 'contabilidad'))
                            <a href="{{route('curso.edit', $curso->id)}}" class="btn btn-primary">Editar</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection