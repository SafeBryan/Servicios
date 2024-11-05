<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Basic CRUD Application - Bootstrap CRUD Demo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script</head>
<body>
    <div class="container mt-5">
        <h2>Basic CRUD Application</h2>
        <p>Use los botones para realizar acciones CRUD.</p>
        
        <!-- Search and Actions -->
        <div class="d-flex mb-3">
            <input id="cedulaSearch" type="text" class="form-control me-2" placeholder="Buscar por cédula" style="width: 200px;">
            <button class="btn btn-primary me-2" onclick="searchByCedula()">Buscar</button>
            <button class="btn btn-success me-2" onclick="newUser()">Nuevo Estudiante</button>
            <button class="btn btn-warning me-2" onclick="editUser()">Editar Estudiante</button>
            <button class="btn btn-danger" onclick="destroyUser()">Eliminar Estudiante</button>
        </div>
        
        <!-- Student Table -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th scope="col">Cédula</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Teléfono</th>
                </tr>
            </thead>
            <tbody id="studentsTable">
                <!-- Rows will be populated here with AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Modal for Adding/Editing Student -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Nuevo Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="studentForm">
                        <div class="mb-3">
                            <label for="cedulaField" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="cedulaField" name="cedula" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombreField" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreField" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidoField" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellidoField" name="apellido" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccionField" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccionField" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefonoField" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefonoField" name="telefono" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveUser()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var url;
        function newUser() {
            $('#studentModalLabel').text('Nuevo Estudiante');
            $('#studentForm')[0].reset();
            $('#cedulaField').prop('readonly', false);
            url = '../controllers/apiRest.php';
            $('#studentModal').modal('show');
        }

        function editUser() {
            var selectedRow = $('#studentsTable .table-active');
            if (selectedRow.length) {
                $('#studentModalLabel').text('Editar Estudiante');
                $('#cedulaField').val(selectedRow.data('cedula')).prop('readonly', true);
                $('#nombreField').val(selectedRow.data('nombre'));
                $('#apellidoField').val(selectedRow.data('apellido'));
                $('#direccionField').val(selectedRow.data('direccion'));
                $('#telefonoField').val(selectedRow.data('telefono'));
                url = '../controllers/apiRest.php?cedula=' + selectedRow.data('cedula');
                $('#studentModal').modal('show');
            }
        }

        function saveUser() {
            var method = url.includes('cedula') ? 'PUT' : 'POST';
            $.ajax({
                url: url,
                type: method,
                data: $('#studentForm').serialize(),
                success: function (result) {
                    $('#studentModal').modal('hide');
                    loadStudents();
                },
                error: function (error) {
                    alert('Error: ' + error.responseText);
                }
            });
        }

        function searchByCedula() {
            var cedula = $('#cedulaSearch').val();
            loadStudents(cedula);
        }

        function loadStudents(cedula = null) {
    const data = cedula ? { cedula: cedula } : {}; // Solo enviar 'cedula' si tiene valor

    $.ajax({
        url: '../controllers/apiRest.php',
        type: 'GET',
        data: data,
        success: function (data) {
            var students = JSON.parse(data);
            var rows = '';
            students.forEach(student => {
                rows += `<tr data-cedula="${student.cedula}" data-nombre="${student.nombre}" data-apellido="${student.apellido}" data-direccion="${student.direccion}" data-telefono="${student.telefono}">
                            <td>${student.cedula}</td>
                            <td>${student.nombre}</td>
                            <td>${student.apellido}</td>
                            <td>${student.direccion}</td>
                            <td>${student.telefono}</td>
                        </tr>`;
            });
            $('#studentsTable').html(rows);
        },
        error: function (error) {
            alert('Error: ' + error.responseText);
        }
    });
}


        function destroyUser() {
            var selectedRow = $('#studentsTable .table-active');
            if (selectedRow.length) {
                var cedula = selectedRow.data('cedula');
                if (confirm('¿Seguro que quieres eliminar a este estudiante?')) {
                    $.ajax({
                        url: "../controllers/apiRest.php?cedula=" + cedula,
                        type: "DELETE",
                        success: function () {
                            loadStudents();
                        },
                        error: function (error) {
                            alert('Error: ' + error.responseText);
                        }
                    });
                }
            }
        }

        $(document).on('click', '#studentsTable tr', function () {
            $('#studentsTable tr').removeClass('table-active');
            $(this).addClass('table-active');
        });

        $(document).ready(function () {
            loadStudents();
        });
    </script>
</body>
</html>
