<?php
 //Ejemplo: php scripts/notificar_reservas.php 1440 para revisar de mas de un dia

require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;


$minutos = $argv[1] ?? 30;
echo "Buscando reservas pendientes de más de {$minutos} minutos...\n";

$conn = getConnection_BD();
$sql = "SELECT r.idReserva, r.fecha,
               TIMESTAMPDIFF(MINUTE, r.fecha, NOW()) as minutos_transcurridos,
               ride.nombre as ride_nombre, ride.salida, ride.llegada, 
               ride.fecha as fecha_viaje, ride.hora,
               pasajero.nombre as pasajero_nombre,
               chofer.nombre as chofer_nombre, chofer.correo as chofer_correo
        FROM reserva r
        JOIN ride ON r.idRide = ride.idRide
        JOIN vehiculos v ON ride.idVehiculo = v.idVehiculo
        JOIN usuarios chofer ON v.idUsuario = chofer.idUsuario
        JOIN usuarios pasajero ON r.idUsuario = pasajero.idUsuario
        WHERE r.estado = 'Pendiente' AND TIMESTAMPDIFF(MINUTE, r.fecha, NOW()) > ?
        ORDER BY chofer.correo";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $minutos);
$stmt->execute();
$reservas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if (empty($reservas)) {
    echo "No hay reservas pendientes.\n";
    exit();
}

echo "Encontradas " . count($reservas) . " reservas pendientes.\n";

$choferes = [];
foreach ($reservas as $reserva) {
    $correo = $reserva['chofer_correo'];
    $choferes[$correo]['nombre'] = $reserva['chofer_nombre'];
    $choferes[$correo]['reservas'][] = $reserva;
}

$enviados = 0;
foreach ($choferes as $correo => $datos) {
    echo "Enviando correo a: {$datos['nombre']} ({$correo})... ";
    
    $lista = "";
    foreach ($datos['reservas'] as $r) {
        $lista .= "- Reserva #{$r['idReserva']}: {$r['ride_nombre']}<br>";
        $lista .= "  Pasajero: {$r['pasajero_nombre']}<br>";
        $lista .= "  Ruta: {$r['salida']} → {$r['llegada']}<br>";
        $lista .= "  Fecha: {$r['fecha_viaje']} a las {$r['hora']}<br><br>";
    }
    
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'aventomescr@gmail.com';
        $mail->Password = 'ubon jmov ryip sxmk'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('aventomescr@gmail.com', 'RideConnect');
        $mail->addAddress($correo, $datos['nombre']);
        $mail->isHTML(true);
        $mail->Subject = 'Solicitudes de reserva pendientes';
        
        $mail->Body = "Hola {$datos['nombre']},<br><br>
                       Tienes " . count($datos['reservas']) . " solicitud(es) pendiente(s):<br><br>
                       {$lista}
                       Revisa tu panel para aceptar o rechazar.<br><br>
                       Saludos,<br>RideConnect";

        $mail->send();
        echo "Enviado\n";
        $enviados++;
    } catch (Exception $e) {
        echo "Error\n";
    }
}

echo "\nResumen: {$enviados} correos enviados, " . count($reservas) . " reservas.\n";
$conn->close();
?>