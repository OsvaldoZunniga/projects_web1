<?php 
require_once '../database/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getConnection_BD();

    session_start();
    $userId = $_SESSION['idUsuario'];

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nacimiento = $_POST['nacimiento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    
    


    $contrasena = $_POST['contrasena'];
    $contrasena_confirm = $_POST['contrasena_confirm'];
    
    if ($contrasena !== $contrasena_confirm) {
        header("Location: ../pages/profile_settings.php?msg=passwrd_!match");
        exit;
    }
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);


    $foto_ruta = '';
        if (!empty($_FILES['fotografia']['name'])) {
            $carpeta = '../assets/';
            if (!is_dir($carpeta)) mkdir($carpeta, 0755, true);

            $nuevoNombre = time() . '_' . basename($_FILES['fotografia']['name']);
            $destino = $carpeta . $nuevoNombre;

            if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $destino)) {
                $foto_ruta = 'assets/' . $nuevoNombre; 
            } else {
                header("Location: ../index.php?msg=img_upload_error");
            }
        }
        // Borrar la antigua fotografía
        
        if (!empty($fotografia)) {
            $sql_foto = "SELECT fotografia FROM usuarios WHERE idUsuario = ?";
            $stmt_foto = $conn->prepare($sql_foto);
            $stmt_foto->bind_param("i", $userId);
            $stmt_foto->execute();
            $stmt_foto->bind_result($old_foto);
            $stmt_foto->fetch();
            $stmt_foto->close();
            if ($old_foto && file_exists("../" . $old_foto)) {
                unlink("../" . $old_foto);
            }
        }
        





    $sql = "UPDATE usuarios SET 
            nombre = ?, 
            apellido = ?, 
            nacimiento = ?, 
            correo = ?, 
            telefono = ?, 
            fotografia = ?, 
            contrasena = ? 
            WHERE idUsuario = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nombre, $apellido, $nacimiento, $correo, $telefono, $foto_ruta, $contrasena_hash, $userId);

    

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: ../pages/dashboard.php?msg=update_success");
        exit;
        
        
        
    } else {
        $stmt->close();
        $conn->close();
        header("Location: ../pages/profile_settings.php?msg=update_error");
        exit;
    }
}
?>