<?php
require_once 'connection.php';

// Obtiene lista de usuarios activos con sus roles - se usa en dashB_Admin.php
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

// Desactiva un usuario por ID (cambia a Inactivo) - Usada en adminActions.php
function desactivarUsuario($conn, $idUsuario) {
    $sql = "UPDATE usuarios SET estado = 'Inactivo' WHERE idUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    return $stmt->execute();
}

// Obtiene todos los vehículos de un usuario específico - Usada en: dashb_chofer.php, rides_settings.php, addRide.php
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

// Obtiene datos de un vehículo específico por ID - Usada en: vehicles_settings.php, rides_settings.php, update_vehicles.php, update_rides.php
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

// Obtiene datos de un ride específico por ID con info del vehículo - Usada en: rides_settings.php, update_rides.php
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

// Obtiene todos los rides creados por un usuario específico - Usada en: dashb_chofer.php
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

// Obtiene rides públicos con filtros y ordenamiento - Usada en: dashb_pasajero.php, public_rides.php
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

// Verifica si una cédula ya existe en la base de datos - Usada en: users.php
function verificarCedulaExiste($conn, $cedula) {
    $sql = "SELECT idUsuario FROM usuarios WHERE cedula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Verifica si un correo ya existe en la base de datos - Usada en: users.php
function verificarCorreoExiste($conn, $correo) {
    $sql = "SELECT idUsuario FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Inserta una nueva reserva en la base de datos - Usada en: reservas.php
function insertarReserva($conn, $idRide, $idUsuario) {
    $sql = "INSERT INTO reserva(idRide, idUsuario) 
            VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idRide, $idUsuario);
    return $stmt->execute();
}

// Obtiene todas las reservas de un usuario específico - Usada en: dashb_pasajero.php
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
// Actualiza el estado de una reserva (Aceptada/Rechazada/Cancelada) - Usada en: update_reservas.php
function actualizarEstadoReserva($conn, $idReserva, $action) {
    $sql = "UPDATE reserva SET estado = ? WHERE idReserva = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $action, $idReserva);
    return $stmt->execute();
}

// Obtiene todas las reservas con estado Pendiente - Usada en: dashb_chofer.php (para mostrar notificaciones)
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

