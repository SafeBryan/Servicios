<?php
//RequestMethod
include '../models/acceder.php';
include '../models/guardar.php';
include '../models/borrar.php';
include '../models/actualizar.php';
include '../models/buscar.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST' && isset($_REQUEST['_method']) && $_REQUEST['_method'] == 'DELETE') {
    $method = 'DELETE';
}

switch ($method) {
    case 'GET':
        if (isset($_GET['cedula'])) {
            crudC::buscarEstudiantePorCedula($_GET['cedula']);
        } else {
            crudS::seleccionarEstudiantes();
        }
        break;
    case 'POST':
        crudI::insertarEstudiantes();
        break;
    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);
        $_POST = $_PUT;
        crudA::actualizarEstudiantes();
        break;
    case 'DELETE':
        crudB::borrarEstudiantes();
        break;
}





?>