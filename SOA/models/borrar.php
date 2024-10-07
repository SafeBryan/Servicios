<?php
    include_once 'conexion.php';
    class crudB{
    public static function borrarEstudiantes(){
    $objetoConexion = new conexion();
    $conn = $objetoConexion->conectar();
    $cedula=$_GET['cedula'];
    $borrarEstudiantes = "DELETE  FROM estudiantes where cedula='$cedula'";
    $result = $conn->prepare($borrarEstudiantes);
    $result->execute();
    $dataJson = json_encode("Se Elimino Correctamente");
    print_r($dataJson);
        }
    }
?>