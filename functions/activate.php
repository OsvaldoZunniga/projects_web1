<?php
require_once '../database/connection.php';

$conn = getConnection_BD();

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = trim($_GET['email']);
    $token = trim($_GET['token']);

    $sql = "SELECT idUsuario FROM usuarios WHERE correo=? AND token=? AND estado='Pendiente'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $sqlUpdate = "UPDATE usuarios SET estado='Activo', token=NULL WHERE correo=? AND token=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("ss", $email, $token);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        header("Location: ../pages/login.php?msg=activated");
        exit();

    } else {
        header("Location: ../pages/login.php?msg=invalid");
        exit();
    }

    $stmt->close();
    } else {
        echo "Datos inválidos."; //considerar tambien una aerlta
    }

$conn->close();
?>
