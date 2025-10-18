<?php 
require_once '../database/connection.php';

$conn = getConnection_BD();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $nacimiento = $_POST['nacimiento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $contrasena = $_POST['contrasena'];
    $contrasena_confirm = $_POST['contrasena_confirm'];
    $idRoles = $_POST['idRoles'];

    if ($contrasena !== $contrasena_confirm) {
        die("Las contraseñas no coinciden.");
    }

    $contrasena_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

    $foto_ruta = '';
    if (!empty($_FILES['fotografia']['name'])) {
        $carpeta = '../assets/';
        if (!is_dir($carpeta)) mkdir($carpeta, 0755, true);

        $nuevoNombre = time() . '_' . basename($_FILES['fotografia']['name']);
        $destino = $carpeta . $nuevoNombre;

        if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $destino)) {
            $foto_ruta = 'assets/' . $nuevoNombre; 
        } else {
            echo "No se pudo subir la imagen.";
        }
    }


    $sql = "INSERT INTO usuarios 
        (nombre, apellido, cedula, nacimiento, correo, telefono, fotografia, contrasena, idRoles) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $nombre, $apellido, $cedula, $nacimiento, $correo, $telefono, $foto_ruta, $contrasena_hashed, $idRoles);

    if ($stmt->execute()) {
        echo "Usuario registrado correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
