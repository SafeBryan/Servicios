<?php
include_once 'conexion.php';
class crudC {
    public static function buscarEstudiantePorCedula($cedula) {
        $objetoConexion = new conexion();
        $conn = $objetoConexion->conectar();
        
        $sql = "SELECT * FROM estudiantes WHERE cedula like '".$cedula."%'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

}




?>