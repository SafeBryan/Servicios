<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['cedula'])) {
    // Si no se ha enviado una cédula, mostramos el formulario en HTML
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Consulta de Transacciones</title>

    </head>
    <body>
        <div class="container">
            <h1>Consulta de Transacciones Bancarias</h1>
            <form id="cedulaForm">
                <label for="cedula">Ingrese su cédula:</label><br>
                <input type="text" id="cedula" name="cedula" required><br>
                <button type="submit">Consultar</button>
            </form>
            <div class="mensaje" id="mensaje"></div>
            <table id="tablaTransacciones" style="display:none;">
                <thead>
                    <tr>
                        <th>Tipo de Transacción</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody id="transaccionesBody"></tbody>
            </table>
        </div>

        <script>
            document.getElementById('cedulaForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const cedula = document.getElementById('cedula').value;
                if (cedula) {
                    fetch(`index.php?cedula=${cedula}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.errorMsg) {
                                document.getElementById('mensaje').textContent = data.errorMsg;
                                document.getElementById('tablaTransacciones').style.display = 'none';
                            } else {
                                document.getElementById('mensaje').textContent = `Saldo: ${data.saldo}`;
                                const tbody = document.getElementById('transaccionesBody');
                                tbody.innerHTML = '';
                                data.transacciones.forEach(transaccion => {
                                    const row = document.createElement('tr');
                                    const tipoCell = document.createElement('td');
                                    tipoCell.textContent = transaccion.tipo_transaccion;
                                    const montoCell = document.createElement('td');
                                    montoCell.textContent = transaccion.monto;
                                    row.appendChild(tipoCell);
                                    row.appendChild(montoCell);
                                    tbody.appendChild(row);
                                });
                                document.getElementById('tablaTransacciones').style.display = 'table';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    document.getElementById('mensaje').textContent = 'Por favor, ingrese una cédula válida.';
                    document.getElementById('tablaTransacciones').style.display = 'none';
                }
            });
        </script>
    </body>
    </html>
    <?php
} else if (isset($_GET['cedula'])) {
    include 'crudC.php';
    crudC::buscarTransaccionesPorCedula($_GET['cedula']);
}
?>
