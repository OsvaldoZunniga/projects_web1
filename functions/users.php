<?php 
require_once '../database/connection.php'; 
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


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
    $token = '';

    if ($contrasena !== $contrasena_confirm) {
        header("Location: ../pages/signUpUsers.php?msg=pass_mismatch");
        exit;
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

    $token = bin2hex(random_bytes(16));

    $sql = "INSERT INTO usuarios 
        (nombre, apellido, cedula, nacimiento, correo, telefono, fotografia, contrasena, idRoles, token) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $nombre, $apellido, $cedula, $nacimiento, $correo, $telefono, $foto_ruta, $contrasena_hashed, $idRoles, $token);

    //correos
    if ($stmt->execute()) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'aventomescr@gmail.com';
            $mail->Password = 'ubon jmov ryip sxmk'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('aventomescr@gmail.com', 'AventonesCR');
            $mail->addAddress($correo, $nombre);

            $mail->isHTML(true);
            $mail->Subject = 'Activar cuenta';
            
            $activationLink = "http://localhost/projects_web1/functions/activate.php?email=$correo&token=$token";
            $mail->Body = "Hola $nombre,<br><br>Para activar tu cuenta, haz clic en el siguiente enlace:<br>
                           <a href='$activationLink'>Activar cuenta</a><br><br>Gracias!";

            $mail->send();
           header("Location: ../index.php?msg=pending");
           exit();
        } catch (Exception $e) {
            header("Location: ../index.php??msg=invalid");
            exit();
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}


function getProfileIcon($email) {
    $conn = getConnection_BD();
    $sql = "SELECT fotografia FROM usuarios WHERE correo = '$email' LIMIT 1";
    $result = $conn->query($sql);
    $user = $result ? $result->fetch_assoc() : null;
    if ($result) $result->free();
    $conn->close();
    

    return $user ? $user['fotografia'] : '/assets/default-profile.png';
}



?>
