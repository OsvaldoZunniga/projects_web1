DELIMITER //
--Proceso almacenado para actualizar el estado del ride si ya esta lleno
--Es llamado por el trigger luego de cada update en la tabla
CREATE PROCEDURE actualizar_ride_completo(IN ride_id INT)
BEGIN
    DECLARE espacios_ride INT;
    DECLARE reservas_aceptadas INT;
    
    SELECT espacios INTO espacios_ride
    FROM ride
    WHERE idRide = ride_id;
    
    SELECT COUNT(*) INTO reservas_aceptadas
    FROM reserva
    WHERE idRide = ride_id 
    AND estado = 'Aceptado';
    
    IF reservas_aceptadas >= espacios_ride THEN
        UPDATE ride
        SET estado = 'Realizado'
        WHERE idRide = ride_id;
    END IF;
END//

DELIMITER ;



DELIMITER //

CREATE TRIGGER trg_actualizar_ride_completo_update
AFTER UPDATE ON reserva
FOR EACH ROW
BEGIN
    IF NEW.estado = 'Aceptado' AND OLD.estado != 'Aceptado' THEN
        CALL actualizar_ride_completo(NEW.idRide);
    END IF;
END//

DELIMITER ;




