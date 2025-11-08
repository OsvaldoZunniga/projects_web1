<?php
    $action = $_POST['action'];
    $idReserva = $_POST['idReserva'];
    require_once '../database/connection.php';
    require_once '../database/queries.php';
    $conn = getConnection_BD();
    if ($action === 'cancelar') {
        $action = 'Cancelada';
        $query = actualizarEstadoReserva($conn, $idReserva, $action);
        if ($query) {
            header("Location: ../pages/dashboard.php?msg=reservation_canceled");
        } else {
            header("Location: ../pages/dashboard.php?msg=reservation_cancel_error");
        }
    }
    elseif ($action === 'aceptar') {
        $action = 'Aceptado';
        $query = actualizarEstadoReserva($conn, $idReserva, $action);
        if ($query) {
            header("Location: ../pages/dashboard.php?msg=reservation_accepted");
        } else {
            header("Location: ../pages/dashboard.php?msg=reservation_accept_error");
        }
    } else {
        header("Location: ../pages/dashboard.php?msg=invalid_action");
    }

?>