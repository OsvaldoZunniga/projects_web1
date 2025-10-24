<?php
require_once 'connection.php';

function obtenerUsuariosActivos($conn) {
    $sql = "SELECT u.idUsuario, u.nombre, u.apellido, u.cedula, u.correo, r.nombreRol
            FROM usuarios u
            INNER JOIN roles r ON u.idRoles = r.idRoles
            WHERE u.estado = 'Activo'";
    $result = $conn->query($sql);
    if (!$result) {
        die("Error al obtener usuarios: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function desactivarUsuario($conn, $idUsuario) {
    $sql = "UPDATE usuarios SET estado = 'Inactivo' WHERE idUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    return $stmt->execute();
}


?>
