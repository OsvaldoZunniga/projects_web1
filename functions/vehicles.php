<?php
require_once '../database/connection.php';

$conn = getConnection_BD();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idUsuario = $_POST['idUsuario'];
    $placa = $_POST['placa'];
    $color = $_POST['color'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $capacidad = $_POST['capacidad'];
    

    $foto_ruta = '';
    if (!empty($_FILES['foto']['name'])) {
        $carpeta = '../assets/';
        if (!is_dir($carpeta)) mkdir($carpeta, 0755, true);

        $nuevoNombre = time() . '_' . basename($_FILES['foto']['name']);
        $destino = $carpeta . $nuevoNombre;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
            $foto_ruta = 'assets/' . $nuevoNombre;
        }
    }

    $sql = "INSERT INTO vehiculos (idUsuario, placa, color, marca, modelo, anio, capacidad, foto)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssds", $idUsuario, $placa, $color, $marca, $modelo, $anio, $capacidad, $foto_ruta);

    if ($stmt->execute()) {
        header("Location: ../pages/dashboard.php?msg=added");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
