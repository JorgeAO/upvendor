INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220630_1155');

CREATE TABLE `upvendor`.`tb_cli_cliente` ( 
    `cliente_id` INT NOT NULL AUTO_INCREMENT , 
    `fk_par_tipo_persona` INT NOT NULL , 
    `fk_par_tipo_identificacion` INT NOT NULL , 
    `cliente_identificacion` VARCHAR(20) NOT NULL , 
    `cliente_nombre` VARCHAR(100) NOT NULL , 
    `cliente_apellido` VARCHAR(100) NOT NULL , 
    `cliente_razonsocial` VARCHAR(200) NOT NULL , 
    `cliente_celular` VARCHAR(10) NOT NULL , 
    `cliente_correo` VARCHAR(100) NOT NULL , 
    `cliente_maxdiasmora` INT NOT NULL , 
    `cliente_ttodatos` VARCHAR(1) NOT NULL , 
    `cliente_fttodatos` DATETIME NOT NULL , 
    `cliente_fnacimiento` DATETIME NOT NULL , 
    `cliente_pubcorreo` VARCHAR(1) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`cliente_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_modulos` (`modulos_id`, `modulos_descripcion`, `modulos_prefijo`, `modulos_icono`, `fk_par_estados`, `fc`, `uc`, `fm`, `um`) 
VALUES (NULL, 'Clientes', 'cli', 'user-friends', '1', '0000-00-00 00:00:00', '0', NULL, NULL);

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) VALUES ('3001', '3', 'Clientes', '/clientes/index', '1');

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220630_1155';