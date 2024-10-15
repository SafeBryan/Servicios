<?php
include_once 'conexion.php';

class crudC {
    public static function buscarTransaccionesPorCedula($cedula) {
        $objetoConexion = new Conexion();
        $conn = $objetoConexion->conectar();

        $selectTransacciones = "SELECT tipo_transaccion, monto FROM transacciones WHERE cedula = :cedula";
        $stmt = $conn->prepare($selectTransacciones);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        $transacciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($transacciones) {
            $saldo = 0;

            // Calculamos el saldo basado en las transacciones
            foreach ($transacciones as $transaccion) {
                if ($transaccion['tipo_transaccion'] == 'deposito') {
                    $saldo += $transaccion['monto'];
                } elseif ($transaccion['tipo_transaccion'] == 'retiro') {
                    $saldo -= $transaccion['monto'];
                }
            }

            // Retornamos el saldo en formato JSON
            $response = json_encode([
                "cedula" => $cedula,
                "saldo" => $saldo,
                "transacciones" => $transacciones
            ]);
        } else {
            $response = json_encode(["errorMsg" => "No se encontraron transacciones para la cédula $cedula"]);
        }

        print_r($response);
    }
}
?>
