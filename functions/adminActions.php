<?php
require_once '../database/connection.php';
require_once '../database/queries.php';

$conn = getConnection_BD();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'], $_POST['accion'])) {
    if ($_POST['accion'] === 'desactivar') {
        if (desactivarUsuario($conn, $_POST['idUsuario'])) {
            header("Location: ../pages/dashboard.php?msg=desactivado");
            exit();
        } else {
            header("Location: ../pages/dashboard.php?msg=error_desactivar");
            exit();
        }
    }
}

$conn->close();
