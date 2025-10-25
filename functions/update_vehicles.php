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
    $idVehiculo = $_POST['idVehiculo'];
    $accion = $_POST['accion'];
    
    $vehiculo = obtenerVehiculoPorId($conn, $idVehiculo);
    
    if (!$vehiculo || $vehiculo['idUsuario'] != $_SESSION['idUsuario']) {
        header("Location: ../pages/dashboard.php?msg=unauthorized");
        exit();
    }
    
    if ($accion === 'actualizar') {
        $placa = $_POST['placa'];
        $color = $_POST['color'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $anio = $_POST['anio'];
        $capacidad = $_POST['capacidad'];
        
        $foto_ruta = $vehiculo['foto'];       
        if (!empty($_FILES['foto']['name'])) {
            $carpeta = '../assets/';
            if (!is_dir($carpeta)) mkdir($carpeta, 0755, true);

            $nuevoNombre = time() . '_' . basename($_FILES['foto']['name']);
            $destino = $carpeta . $nuevoNombre;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                if (!empty($vehiculo['foto']) && file_exists('../' . $vehiculo['foto'])) {
                    unlink('../' . $vehiculo['foto']);
                }
                $foto_ruta = 'assets/' . $nuevoNombre;
            }
        }
        
        $sql = "UPDATE vehiculos SET placa = ?, color = ?, marca = ?, modelo = ?, anio = ?, capacidad = ?, foto = ? WHERE idVehiculo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssisi", $placa, $color, $marca, $modelo, $anio, $capacidad, $foto_ruta, $idVehiculo);
        
        if ($stmt->execute()) {
            header("Location: ../pages/dashboard.php?msg=updated");
        } else {
            header("Location: ../pages/vehicles_settings.php?id=$idVehiculo&msg=error");
        }
        
        $stmt->close();
        
    } elseif ($accion === 'eliminar') {

        if (!empty($vehiculo['foto']) && file_exists('../' . $vehiculo['foto'])) {
            unlink('../' . $vehiculo['foto']);
        }
        
        $sql = "DELETE FROM vehiculos WHERE idVehiculo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idVehiculo);
        
        if ($stmt->execute()) {
            header("Location: ../pages/dashboard.php?msg=deleted");
        } else {
            header("Location: ../pages/vehicles_settings.php?id=$idVehiculo&msg=error");
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>
