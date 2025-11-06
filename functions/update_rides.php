<?php
session_start();

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 1) {
    header("Location: ../index.php?msg=invalid");
    exit();
}

require_once '../database/connection.php';
require_once '../database/queries.php';

$conn = getConnection_BD();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idRide = $_POST['idRide'];
    $accion = $_POST['accion'];
    
    $ride = obtenerRidePorId($conn, $idRide);
    
    if (!$ride) {
        header("Location: ../pages/dashboard.php?msg=unauthorized");
        exit();
    }

    $vehiculo = obtenerVehiculoPorId($conn, $ride['idVehiculo']);
    if (!$vehiculo || $vehiculo['idUsuario'] != $_SESSION['idUsuario']) {
        header("Location: ../pages/dashboard.php?msg=unauthorized");
        exit();
    }
    
    if ($accion === 'actualizar') {
        $vehiculoId = $_POST['vehiculo'];
        $nombre = $_POST['nombre'];
        $salida = $_POST['salida'];
        $llegada = $_POST['llegada'];
        $hora = $_POST['hora'];
        $fecha = $_POST['fecha'];
        $espacios = $_POST['espacios'];
        $precio_espacio = $_POST['precio_espacio'];
        
        $sql = "UPDATE ride SET idVehiculo = ?, nombre = ?, salida = ?, llegada = ?, hora = ?, fecha = ?, espacios = ?, costo_espacio = ? WHERE idRide = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssidi", $vehiculoId, $nombre, $salida, $llegada, $hora, $fecha, $espacios, $precio_espacio, $idRide);
        
        if ($stmt->execute()) {
            header("Location: ../pages/dashboard.php?msg=updated");
        } else {
            header("Location: ../pages/rides_settings.php?id=$idRide&msg=error");
        }
        
        $stmt->close();
        
    } elseif ($accion === 'eliminar') {
        
        $sql = "DELETE FROM ride WHERE idRide = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idRide);
        
        if ($stmt->execute()) {
            header("Location: ../pages/dashboard.php?msg=deleted");
        } else {
            header("Location: ../pages/rides_settings.php?id=$idRide&msg=error");
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>
