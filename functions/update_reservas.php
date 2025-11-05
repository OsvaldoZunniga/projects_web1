<?php
    $action = $_POST['action'];
    $idReserva = $_POST['idReserva'];
    require_once '../database/connection.php';
    require_once '../database/queries.php';
    $conn = getConnection_BD();
    if ($action === 'cancelar') {
        $query = cancelarReserva($conn, $idReserva);
        if ($query) {
            header("Location: ../pages/dashboard.php?msg=reservation_canceled");
        } else {
            header("Location: ../pages/dashboard.php?msg=reservation_cancel_error");
        }
    }

?>