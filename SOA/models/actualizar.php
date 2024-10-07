<?php
include_once 'conexion.php';

class crudA {
    public static function actualizarEstudiantes() {
        $objetoConexion = new conexion();
        $conn = $objetoConexion->conectar();
        $cedula = $_POST['cedula'];  
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $actualizarEstudiante = "UPDATE estudiantes 
                                 SET nombre = :nombre, apellido = :apellido, direccion = :direccion, telefono = :telefono
                                 WHERE cedula = :cedula";
        $stmt = $conn->prepare($actualizarEstudiante);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        if ($stmt->execute()) {
            $response = json_encode(["message" => "Estudiante actualizado exitosamente"]);
        } else {
            $response = json_encode(["errorMsg" => "Error al actualizar el estudiante"]);
        }
        print_r($response);
    }
}
?>
