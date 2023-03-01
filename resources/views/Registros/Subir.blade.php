@extends('layouts.app')

@section('content')
    <form action="{{ route('subirReg') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container card" id="registros-container" style="background-color: white; height: 500px;">
            <div class="row p-2 pt-5">
                <div class="col">
                    <div class="mb-3">
                        <label for="subirArchivo" class="form-label">Tipo de Registro que se subira</label>
                        <select class="form-select" name="tipoRegistro" id="tipoRegistro">
                            <option value="prioritarios">Lista de Alumnos Prioritarios (XLSX)</option>
                            <option value="nomina">Lista de Alumnos SIGE (XML)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row p-2 pt-5">
                <div class="col">
                    <div class="mb-3">
                        <label for="subirArchivo" class="form-label">Archivo de Registros</label>
                        <input class="form-control" type="file" id="subirArchivo" name="file">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div>
                        <button class="btn btn-primary" type="submit" name="submit">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <style lang="scss">
    </style>
@endsection
