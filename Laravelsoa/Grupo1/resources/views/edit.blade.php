@extends('template')
@section('title','Editar Estudiante')
@section('content')

<h1>Edita al estudiante {{ $estudiante['cedula'] }}</h1>

<form action="{{ url('/estudiantes/'.$estudiante['cedula']) }}" method="POST">
    @method("PUT")
    @csrf
    <div class="mb-3">
        <label for="cedula" class="form-label">Cedula</label>
        <input type="text" name="cedula" id="cedula" value="{{ $estudiante['cedula'] }}" readonly class="form-control">
    </div>
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="{{ $estudiante['nombre'] }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" name="apellido" id="apellido" value="{{ $estudiante['apellido'] }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="direccion" class="form-label">Direccion</label>
        <input type="text" name="direccion" id="direccion" value="{{ $estudiante['direccion'] }}" class="form-control">
    </div>
    <div class="mb-3">
        <label for="telefono" class="form-label">Telefono</label>
        <input type="text" name="telefono" id="telefono" value="{{ $estudiante['telefono'] }}" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
</form>

@endsection
