<?php
    include_once 'conexion.php';

class crudS{
    public static function seleccionarEstudiantes(){
    $objetoConexion = new conexion();
    $conn = $objetoConexion->conectar();

    $selectEstudiantes = "SELECT * FROM estudiantes";
    $result = $conn->prepare($selectEstudiantes);
    $result->execute();
    $data=$result->fetchAll(PDO::FETCH_ASSOC);
    //print_r($data);
    $dataJson = json_encode($data);
    print_r($dataJson);
    }
}
?>