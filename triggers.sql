DELIMITER //

-- Triggers sobre project
DROP TRIGGER IF EXISTS crear_proyecto //
CREATE TRIGGER crear_proyecto AFTER INSERT ON project
FOR EACH ROW
BEGIN
	INSERT INTO actividad (usuario_id, proyecto_id, tipo, actividad, fecha)
	VALUES (NEW.autor_id, NEW.id, 'Añadir', 'ha creado el proyecto', NOW());
END//

DROP TRIGGER IF EXISTS actualizar_proyecto //
CREATE TRIGGER actualizar_proyecto AFTER UPDATE ON project
FOR EACH ROW
BEGIN
	INSERT INTO actividad (usuario_id, proyecto_id, tipo, actividad, fecha)
	VALUES (NEW.autor_id, NEW.id, 'Editar', 'ha editado el proyecto', NOW());
END//

-- Triggers sobre seguimiento

DROP TRIGGER IF EXISTS nuevo_seguimiento //
CREATE TRIGGER nuevo_seguimiento AFTER INSERT ON seguimiento
FOR EACH ROW
BEGIN
	INSERT INTO actividad (usuario_id, proyecto_id, tipo, actividad, fecha)
	VALUES (NEW.usuario_id, NEW.proyecto_id, 'Añadir', 'ha creado un nuevo seguimiento', NOW()); 
END//

DROP TRIGGER IF EXISTS editar_seguimiento //
CREATE TRIGGER editar_seguimiento AFTER UPDATE ON seguimiento
FOR EACH ROW
BEGIN
	INSERT INTO actividad (usuario_id, proyecto_id, tipo, actividad, fecha)
	VALUES (NEW.usuario_id, NEW.proyecto_id, 'Editar', 'ha editado el seguimiento', NOW()); 
END//

-- Triggers sobre colaboracion

DROP TRIGGER IF EXISTS nueva_colaboracion //
CREATE TRIGGER nueva_colaboracion AFTER INSERT ON colaboracion
FOR EACH ROW
BEGIN
	INSERT INTO actividad (usuario_id, proyecto_id, tipo, actividad, fecha)
	VALUES (NEW.usuario_id, NEW.proyecto_id, 'Añadir', 'ha comenzado a colaborar en', NOW()); 
END//

DROP TRIGGER IF EXISTS quitar_colaboracion //
CREATE TRIGGER quitar_colaboracion AFTER DELETE ON colaboracion
FOR EACH ROW
BEGIN
	INSERT INTO actividad (usuario_id, proyecto_id, tipo, actividad, fecha)
	VALUES (OLD.usuario_id, OLD.proyecto_id, 'Eliminar', 'ha dejado de colaborar en', NOW()); 
END//

-- Triggers sobre valoraciones

DROP PROCEDURE IF EXISTS megusta_actividad //
CREATE PROCEDURE megusta_actividad(_megusta BOOL, _usuario INT, _proyecto INT)
BEGIN
	IF _megusta = true THEN
		INSERT INTO actividad (usuario_id, proyecto_id, tipo, actividad, fecha)
		VALUES (_usuario, _proyecto, 'Añadir', 'le ha gustado', NOW());
	ELSE
		INSERT INTO actividad (usuario_id, proyecto_id, tipo, actividad, fecha)
		VALUES (_usuario, _proyecto, 'Añadir', 'no le ha gustado', NOW());
    END IF;
END//

DROP TRIGGER IF EXISTS megusta_proyecto //
CREATE TRIGGER megusta_proyecto AFTER INSERT ON valoracion
FOR EACH ROW
BEGIN
	CALL megusta_actividad(NEW.megusta, NEW.usuario_id, NEW.proyecto_id);
END//

DROP TRIGGER IF EXISTS megusta_proyecto_update //
CREATE TRIGGER megusta_proyecto_update AFTER UPDATE ON valoracion
FOR EACH ROW
BEGIN
	CALL megusta_actividad(NEW.megusta, NEW.usuario_id, NEW.proyecto_id);
END//
