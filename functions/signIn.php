<?php
session_start();
require_once '../database/connection.php';

$conn = getConnection_BD();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    $sql = "SELECT * FROM usuarios WHERE correo=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if ($user['estado'] == 'Pendiente') {
            header("Location: ../index.php?msg=pending");
            exit();
        }
        if ($user['estado'] == 'Inactivo') {
            header("Location: ../index.php?msg=inactive");
            exit();
        }

        if (password_verify($contrasena, $user['contrasena'])) {
            $_SESSION['idUsuario'] = $user['idUsuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['correo'] = $user['correo'];
            $_SESSION['idRoles'] = $user['idRoles'];
            header("Location: ../pages/dashboard.php");
            exit();
        } else {
            header("Location: ../index.php?msg=wrong_pass");  
            exit();         
        }
    } else {
        header("Location: ../index.php?msg=user_not_found");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
