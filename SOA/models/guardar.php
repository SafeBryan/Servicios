<?php
include_once 'conexion.php';
class crudI{
    public static function insertarEstudiantes(){
    $objetoConexion = new conexion();
    $conn = $objetoConexion->conectar();
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $guardarEstudiante = "INSERT INTO estudiantes VALUES('$cedula', '$nombre', '$apellido', '$direccion', '$telefono')";
    $result = $conn->prepare($guardarEstudiante);
    $result->execute();

    $dataJson = json_encode("Se inserto el formato Json");
    print_r($dataJson);
    }
}
?>