@extends('layouts.app')
@section('content')
<div class="container">
    <form class="col-md-10 mt-3 row">
        <h1>Estudiante</h1>
        <div class="form-group mb-3 col-3">
            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" class="form-control" autofocus>
        </div>
        <div class="form-group mb-3 col-3">
            <label for="apellido_materno" class="form-label">Apellido Materno</label>
            <input type="text" name="apellido_materno" class="form-control">
        </div>
        <div class="form-group mb-3 col-6">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" name="nombres" class="form-control">
        </div>
        <div class="form-group mb-3 col-4">
            <label for="run" class="form-label">RUN</label>
            <input type="text" name="run" class="form-control">
        </div>
        <div class="form-group mb-3 col-4">
            <label for="nivel" class="form-label">Nivel</label>
            <input type="text" name="nivel" class="form-control">
        </div>
        <div class="form-group mb-3 col-4">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select name="prioridad" class="form-control">
                <option value="" selected disabled hidden>Selecciona una opción</option>
                <option value="">No proritario</option>
                <option value="">Nuevo proritario</option>
                <option value="">Proritario</option>
            </select>
        </div>
        <h1>Apoderado</h1>
        <div class="form-group mb-3 col-6">
            <label for="fullname" class="form-label">Nombre completo</label>
            <input type="text" name="fullname" class="form-control">
        </div>
        <div class="form-group mb-3 col-6">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>
        <div class="form-group mb-3 col-6">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="text" name="email" class="form-control">
        </div>
    </form>
</div>