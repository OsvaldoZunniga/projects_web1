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

function obtenerVehiculosPorUsuario($conn, $idUsuario) {
    $sql = "SELECT v.idVehiculo, v.placa, v.color, v.marca, v.modelo, v.anio, v.capacidad, v.foto
            FROM vehiculos v
            INNER JOIN usuarios u ON v.idUsuario = u.idUsuario
            WHERE v.idUsuario = ? 
            AND u.estado = 'Activo'
            ORDER BY v.idVehiculo DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerVehiculoPorId($conn, $idVehiculo) {
    $sql = "SELECT v.idVehiculo, v.idUsuario, v.placa, v.color, v.marca, v.modelo, v.anio, v.capacidad, v.foto
            FROM vehiculos v
            INNER JOIN usuarios u ON v.idUsuario = u.idUsuario
            WHERE v.idVehiculo = ?
            AND u.estado = 'Activo'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idVehiculo);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function obtenerRidePorId($conn, $idRide) {
    $sql = "SELECT 
                r.idRide, 
                r.idVehiculo, 
                r.nombre, 
                r.salida, 
                r.llegada, 
                r.hora, 
                r.fecha, 
                r.espacios, 
                r.costo_espacio,
                v.marca,
                v.modelo,
                v.color
            FROM ride r
            INNER JOIN vehiculos v ON r.idVehiculo = v.idVehiculo
            INNER JOIN usuarios u ON v.idUsuario = u.idUsuario
            WHERE r.idRide = ?
            AND u.estado = 'Activo'
            AND v.idVehiculo IS NOT NULL";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idRide);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function obtenerRidesPorUsuario($conn, $idUsuario) {
    $sql = "SELECT 
                r.idRide, 
                r.idVehiculo, 
                r.nombre, 
                r.salida, 
                r.llegada, 
                r.hora, 
                r.fecha, 
                r.espacios, 
                r.costo_espacio,
                v.marca,
                v.modelo,
                v.color
            FROM ride r
            INNER JOIN vehiculos v ON r.idVehiculo = v.idVehiculo
            INNER JOIN usuarios u ON v.idUsuario = u.idUsuario
            WHERE u.idUsuario = ?
            AND u.estado = 'Activo'
            AND v.idVehiculo IS NOT NULL
            ORDER BY r.idRide DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerRidesPublicos($conn, $filtros = [], $orden = 'fecha_asc') {
    $sql = "SELECT 
                r.idRide, 
                r.nombre, 
                r.salida, 
                r.llegada, 
                r.hora, 
                r.fecha, 
                r.espacios,
                r.estado, 
                r.costo_espacio,
                v.marca,
                v.modelo,
                v.anio,
                v.color
            FROM ride r
            INNER JOIN vehiculos v ON r.idVehiculo = v.idVehiculo
            INNER JOIN usuarios u ON v.idUsuario = u.idUsuario
            WHERE r.fecha >= CURDATE() 
            AND u.estado = 'Activo'
            AND r.estado != 'Realizado'
            AND v.idVehiculo IS NOT NULL";
    
    $params = [];
    $types = "";
    
    // Filtros de búsqueda
    if (!empty($filtros['salida'])) {
        $sql .= " AND r.salida LIKE ?";
        $params[] = "%" . $filtros['salida'] . "%";
        $types .= "s";
    }
    
    if (!empty($filtros['llegada'])) {
        $sql .= " AND r.llegada LIKE ?";
        $params[] = "%" . $filtros['llegada'] . "%";
        $types .= "s";
    }
    
    // Ordenamiento
    switch ($orden) {
        case 'fecha_desc':
            $sql .= " ORDER BY r.fecha DESC, r.hora DESC";
            break;
        case 'salida_asc':
            $sql .= " ORDER BY r.salida ASC";
            break;
        case 'salida_desc':
            $sql .= " ORDER BY r.salida DESC";
            break;
        case 'llegada_asc':
            $sql .= " ORDER BY r.llegada ASC";
            break;
        case 'llegada_desc':
            $sql .= " ORDER BY r.llegada DESC";
            break;
        default: // fecha_asc
            $sql .= " ORDER BY r.fecha ASC, r.hora ASC";
            break;
    }
    
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function verificarCedulaExiste($conn, $cedula) {
    $sql = "SELECT idUsuario FROM usuarios WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function verificarCorreoExiste($conn, $correo) {
    $sql = "SELECT idUsuario FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function insertarReserva($conn, $idRide, $idUsuario) {
    $sql = "INSERT INTO reserva(idRide, idUsuario) 
            VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idRide, $idUsuario);
    return $stmt->execute();
}

function obtenerReservasPorUsuario($conn, $idUsuario) {
    $sql = "SELECT 
                res.idReserva,
                res.idRide,
                res.estado,
                r.nombre AS ride_nombre,
                r.salida,
                r.llegada,
                r.fecha,
                r.hora,
                v.marca,
                v.modelo,
                v.color
            FROM reserva res
            INNER JOIN ride r ON res.idRide = r.idRide
            INNER JOIN vehiculos v ON r.idVehiculo = v.idVehiculo
            INNER JOIN usuarios u ON v.idUsuario = u.idUsuario
            WHERE res.idUsuario = ?
            AND u.estado = 'Activo'
            AND v.idVehiculo IS NOT NULL
            ORDER BY res.idReserva DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
function actualizarEstadoReserva($conn, $idReserva, $action) {
    $sql = "UPDATE reserva SET estado = ? WHERE idReserva = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $action, $idReserva);
    return $stmt->execute();
}
function obtenerReservasPendientes($conn) {
    $sql = "SELECT 
                res.idReserva,
                res.idUsuario,
                res.estado,
                u.nombre,
                u.apellido,
                u.cedula,
                u.correo,
                r.nombre AS ride_nombre
            FROM reserva res
            INNER JOIN usuarios u ON res.idUsuario = u.idUsuario
            inner JOIN ride r ON res.idRide = r.idRide
            WHERE res.estado = 'Pendiente'
            ORDER BY res.idReserva DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>

