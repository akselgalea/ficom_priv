@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-3">Becas</h2>
        
        @if(Auth::user()->hasAnyRole('contabilidad', 'admin'))
            <div class="buttons">
                <a href="{{ route('beca.create') }}" class="btn btn-primary">Nueva beca</a>    
            </div>
        @endif

        <div class="row my-3">
            @foreach($becas as $beca)
            <div class="col-4 mb-3">
                <div class="card beca">
                    <div>
                        <div class="nombre">{{ $beca->nombre }}</div>
                        <div class="descuento"><b>Descuento:</b> {{ $beca->descuento }}%</div>
                        <div class="descripcion"><b>Descripción:</b> {{ $beca->descripcion }}</div>
                    </div>

                    <div class="buttons mt-2">
                        <a href="{{route('beca.show', $beca->id)}}" class="btn btn-primary">Ver</a>
                        @if(Auth::user()->hasAnyRole('admin', 'contabilidad'))
                            <a href="{{route('beca.edit', $beca->id)}}" class="btn btn-primary">Editar</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection