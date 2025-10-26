<?php

    if (!isset($_SESSION)) {
        session_start();
    }
        require_once '../database/queries.php';
        require_once '../database/connection.php';
        $conn = getConnection_BD();
        $idUsuario = $_SESSION['idUsuario'];

        $idVehiculo = $_POST['vehiculo'];
        $nombre = $_POST['nombre'];
        $salida = $_POST['salida'];
        $llegada = $_POST['llegada'];
        $hora = $_POST['hora'];
        $fecha = $_POST['fecha'];
        $espacios = $_POST['espacios'];
        $precio_espacio = $_POST['precio_espacio'];


        $sql = "INSERT INTO ride (idVehiculo, nombre, salida, llegada, hora, fecha, espacios, costo_espacio) 
                VALUES ('$idVehiculo', '$nombre', '$salida', '$llegada', '$hora', '$fecha', '$espacios', '$precio_espacio')";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            header("Location: ../pages/dashboard.php?msg=ride_success");
            exit();
        } else {
            header("Location: ../pages/dashboard.php?msg=ride_error");
            exit();
        };

?>