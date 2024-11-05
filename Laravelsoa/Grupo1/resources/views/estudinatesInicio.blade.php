@extends('template')
@section('title','Mostrar Estudinates')
@section('content')


<form method="GET" action="{{ url('estudiantes/') }}" id="myForm">
    <div class="mb-3">
        <label for="cedula" class="form-label">Cedula a Buscar</label>
        <input type="text" class="form-control" id="cedula" name="cedula">
    </div>
    <button type="button" class="btn btn-primary" onclick="submitForm()">Buscar</button>
</form>

<script>
    function submitForm() {
        var cedulaValue = document.getElementById('cedula').value;
        var formAction = "{{ url('estudiantes/') }}" + "/" + cedulaValue;
        document.getElementById('myForm').action = formAction;
        document.getElementById('myForm').submit();
    }
</script>
<h1>Lista de estudiantes</h1>
<a href="{{ url('estudiantes/create') }}" class="btn btn-primary">Crear</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Cedula</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Direccion</th>
            <th scope="col">Telefono</th>
<!--             <th scope="col"></th>
            <th scope="col"></th> -->
        </tr>
    </thead>
    <tbody>
        @foreach($estudiantesArray AS $estudiante)
        <tr>
            <td>{{ $estudiante['cedula'] }}</td>
            <td>{{ $estudiante['nombre'] }}</td>
            <td>{{ $estudiante['apellido'] }}</td>
            <td>{{ $estudiante['direccion'] }}</td>
            <td>{{ $estudiante['telefono'] }}</td>
            <td><a href="{{ url('estudiantes/'. $estudiante['cedula']) .'/edit' }}" class="btn btn-primary">Editar</a></td>
            <td>
                <form action="{{ url('estudiantes/'.$estudiante['cedula']) }}" method="post">
                    @method("DELETE")
                    @csrf
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection