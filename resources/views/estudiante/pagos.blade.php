@extends('layouts.app')
@section('content')
@php
    $descuento = 0;
    if($estudiante->prioridad == 'prioritario') $descuento = 0;
    else if(! is_null($estudiante->beca)) $descuento = $estudiante->beca->descuento;
    $total = $estudiante->curso->arancel * ($descuento / 100);
    $mesAPagar = $estudiante->mesFaltante($estudiante->pagos_anio, $total);
@endphp

<div class="container card">
    <div class="row">
        <h2>Información del estudiante</h2>
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
            <label for="monto_mensual" class="form-label">Monto mensualidad</label>
            <p class="form-control">{{ toCLP($estudiante->curso->arancel) }}</p>
        </div>
        <div class="form-group mb-3 col-4">
            <label for="beca" class="form-label">% Beca</label>
            <p class="form-control">{{ ! is_null($estudiante->beca) ? $estudiante->beca->descuento : 'No tiene beca' }}</p>
        </div>
        <div class="form-group mb-3 col-4">
            <label for="exencion" class="form-label">Total a pagar</label>
            <p class="form-control">{{ toCLP($total) }}</p>
        </div>
    </div>
    <form method="POST" action="{{route('pago.store', $estudiante->id)}}" id="formPago" class="mt-3 row">
        @csrf
        <h2>Registrar pago</h2>
        <div class="form-group mb-3 col-6 col-md-4">
            <label for="mes" class="form-label">Mes</label>
            <select name="mes" class="form-control form-select @error('mes') is-invalid @enderror">
                <option value="" selected disabled hidden>Selecciona una opción</option>
                <option value="matricula" @selected($mesAPagar == 'matricula')>Matrícula</option>
                <option value="marzo" @selected($mesAPagar == 'marzo')>Marzo</option>
                <option value="abril" @selected($mesAPagar == 'abril')>Abril</option>
                <option value="mayo" @selected($mesAPagar == 'mayo')>Mayo</option>
                <option value="junio" @selected($mesAPagar == 'junio')>Junio</option>
                <option value="julio" @selected($mesAPagar == 'julio')>Julio</option>
                <option value="agosto" @selected($mesAPagar == 'agosto')>Agosto</option>
                <option value="septiembre" @selected($mesAPagar == 'septiembre')>Septiembre</option>
                <option value="octubre" @selected($mesAPagar == 'octubre')>Octubre</option>
                <option value="noviembre" @selected($mesAPagar == 'noviembre')>Noviembre</option>
                <option value="diciembre" @selected($mesAPagar == 'diciembre')>Diciembre</option>
            </select>

            @error('mes')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-4">
            <label for="anio" class="form-label">Año</label>
            <select name="anio" class="form-control form-select @error('anio') is-invalid @enderror">
                <option value="" selected disabled hidden>Selecciona una opción</option>
                <option value="2022" @selected(old('anio') == '2022' || now()->year == '2022')>2022</option>
                <option value="2023" @selected(old('anio') == '2023' || now()->year == '2023')>2023</option>
                <option value="2024" @selected(old('anio') == '2024' || now()->year == '2024')>2024</option>
            </select>

            @error('anio')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-4">
            <label for="documento" class="form-label">Documento</label>
            <select name="documento" class="form-control form-select @error('documento') is-invalid @enderror">
                <option value="" selected disabled hidden>Selecciona una opción</option>
                <option value="boleta"  @selected(old('documento') == 'boleta')>Boleta</option>
                <option value="recibo"  @selected(old('documento') == 'recibo')>Recibo</option>
            </select>

            @error('documento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-4">
            <label for="num_documento" class="form-label">N° Documento</label>
            <input type="number" name="num_documento" class="form-control @error('num_documento') is-invalid @enderror" value="{{ old('num_documento') }}">

            @error('num_documento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-4">
            <label for="fecha_pago" class="form-label">Fecha</label>
            <input type="date" name="fecha_pago" class="form-control @error('fecha_pago') is-invalid @enderror" value={{ old('fecha_pago') ? old('fecha_pago') : today()}}>

            @error('fecha_pago')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-4">
            <label for="valor" class="form-label">Valor</label>
            <input type="number" name="valor" class="form-control @error('valor') is-invalid @enderror" value="{{ old('valor') }}">

            @error('valor')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-6 col-md-4">
            <label for="forma" class="form-label">Forma de pago</label>
            <select name="forma" class="form-control form-select @error('forma') is-invalid @enderror">
                <option value="" selected disabled hidden>Selecciona una opción</option>
                <option value="efectivo" @selected(old('forma') == 'efectivo')>Efectivo</option>
                <option value="cheque" @selected(old('forma') == 'cheque')>Cheque</option>
                <option value="transferencia" @selected(old('forma') == 'transferencia')>Transferencia</option>
            </select>

            @error('forma')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3 col-12 col-md-6">
            <label for="observacion" class="form-label">Observaciones</label>
            <textarea name="observacion" class="form-control @error('observacion') is-invalid @enderror">{{ old('observacion') }}</textarea>

            @error('observacion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div>
            <button class="btn btn-primary">Enviar</button>
            <button type="button" class="btn btn-danger" onclick="cancelForm()">Cancelar</button>
        </div>
    </form>
</div>

<div class="container mt-3">
    <div class="tabla-pagos-container">
        <table class="tabla-pagos table table-bordered border-dark">
            <tbody>
                <tr class="datos-estudiante text-center">
                    <td colspan="2" style="width: 45%">{{ $estudiante->apellidos }}</td>
                    <td style="width: 30%">{{ $estudiante->nombres }}</td>
                    <td style="width: 130px">{{ $estudiante->rut . '-' . $estudiante->dv }}</td>
                    <td style="width: 60px">{{ $estudiante->curso->curso . '-' . $estudiante->curso->paralelo }}</td>
                    <td rowspan="2" style="width: 5ch">{{ now()->year }}</td>
                </tr>
                <tr>
                    <td style="width: 10ch">Alumno:</td>
                    <td class="text-center">Apellido paterno y materno</td>
                    <td class="text-center">Nombres</td>
                    <td class="text-center">RUN</td>
                    <td class="text-center">NIVEL</td>
                </tr>
                <tr>
                    <td colspan="6">Nombre Apoderado: {{ $estudiante->apoderado_titular ? $estudiante->apoderado_titular->nombres . ' ' . $estudiante->apoderado_titular->apellidos : '' }}</td>
                </tr>
                <tr>
                    <td colspan="2">Teléfono: {{ $estudiante->apoderado_titular ? $estudiante->apoderado_titular->telefono : '' }}</td>
                    <td colspan="4">Correo Electrónico: {{ $estudiante->apoderado_titular ? $estudiante->apoderado_titular->email : '' }}</td>
                </tr>
            </tbody>
        </table>

        <table class="tabla-pagos table table-bordered border-dark">
            <thead>
              <tr>
                <th scope="col" style="width: 123px">Meses</th>
                <th scope="col" style="width: 123px">Documento</th>
                <th scope="col" style="width: 150px">N° Documento</th>
                <th scope="col" style="width: 120px">Fecha</th>
                <th scope="col" style="width: 130px">Valor</th>
                <th scope="col" style="width: 150px">Forma de pago</th>
                <th scope="col" style="width: auto">Observaciones</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Matrícula</td>
                    @if(count($estudiante->pagos_anio['matricula']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['matricula'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['matricula']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['matricula'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Marzo</td>
                    @if(count($estudiante->pagos_anio['marzo']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['marzo'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['marzo']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['marzo'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Abril</td>
                    @if(count($estudiante->pagos_anio['abril']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['abril'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['abril']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['abril'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Mayo</td>
                    @if(count($estudiante->pagos_anio['mayo']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['mayo'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['mayo']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['mayo'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Junio</td>
                    @if(count($estudiante->pagos_anio['junio']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['junio'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['junio']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['junio'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Julio</td>
                    @if(count($estudiante->pagos_anio['julio']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['julio'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['julio']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['julio'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Agosto</td>
                    @if(count($estudiante->pagos_anio['agosto']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['agosto'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['agosto']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['agosto'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Septiembre</td>
                    @if(count($estudiante->pagos_anio['septiembre']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['septiembre'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['septiembre']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['septiembre'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Octubre</td>
                    @if(count($estudiante->pagos_anio['octubre']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['octubre'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['octubre']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['octubre'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Noviembre</td>
                    @if(count($estudiante->pagos_anio['noviembre']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['noviembre'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['noviembre']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['noviembre'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
                <tr>
                    <td>Diciembre</td>
                    @if(count($estudiante->pagos_anio['diciembre']) > 1)
                        <td class="multiples-pagos" colspan="6">
                            @foreach($estudiante->pagos_anio['diciembre'] as $pago)
                                <div class="detalles">
                                    <div class="text-uppercase" style="width: 123px">{{ $pago['documento'] }}</div>
                                    <div style="width: 150px">{{ $pago['num_documento'] }}</div>
                                    <div style="width: 120px">{{ $pago['fecha_pago'] }}</div>
                                    <div style="width: 130px">{{ toCLP($pago['valor']) }}</div>
                                    <div class="text-capitalize" style="width: 150px">{{ $pago['forma'] }}</div>
                                    <div style="width: auto">{{ $pago['observacion'] }}</div>
                                </div>
                            @endforeach
                        </td>
                    @elseif(count($estudiante->pagos_anio['diciembre']) == 0)
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @else
                        @foreach ($estudiante->pagos_anio['diciembre'] as $pago)    
                            <td class="text-center text-uppercase">{{$pago['documento']}}</td>
                            <td class="text-center">{{$pago['num_documento']}}</td>
                            <td class="text-center">{{$pago['fecha_pago']}}</td>
                            <td class="text-center">{{toCLP($pago['valor'])}}</td>
                            <td class="text-center text-capitalize">{{$pago['forma']}}</td>
                            <td>{{$pago['observacion']}}</td>
                        @endforeach
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

<script>
    function cancelForm() {
        const form = document.getElementById('formPago');
        form.reset();
    }
</script>