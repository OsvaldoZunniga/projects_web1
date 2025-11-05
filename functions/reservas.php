<?php
    session_start();
    require_once '../database/connection.php';
    require_once '../database/queries.php';

    $ride_id = $_POST['ride_id'];
    $idUser = $_SESSION['idUsuario'];
    $conn = getConnection_BD();
    $query = insertarReserva($conn, $ride_id, $idUser);
    if ($query) {
        header("Location: ../pages/dashboard.php?msg=reservation_success");
    } else {
        header("Location: ../pages/dashboard.php?msg=reservation_error");
    }

?>