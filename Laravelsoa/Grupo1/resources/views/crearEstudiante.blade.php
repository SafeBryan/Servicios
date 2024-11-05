@extends('template')
@section('title','Ingresar Estudiante')
@section('content')

<h1>Crear nuevo estudiante</h1>

<form action="{{ url('/estudiantes') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="lblcedula" class="form-label">Cedula</label>
        <input type="text" name="cedula" id="cedula" class="form-control">
    </div>
    <div class="mb-3">
        <label for="lblnombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control">
    </div>
    <div class="mb-3">
        <label for="lblapellido" class="form-label">Apellido</label>
        <input type="text" name="apellido" id="apellido" class="form-control">
    </div>
    <div class="mb-3">
        <label for="lbldireccion" class="form-label">Direccion</label>
        <input type="text" name="direccion" id="direccion" class="form-control">
    </div>
    <div class="mb-3">
        <label for="lbltelefono" class="form-label">Telefono</label>
        <input type="text" name="telefono" id="telefono" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>

@endsection