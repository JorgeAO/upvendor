INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220707_1636');

CREATE TABLE `upvendor`.`tb_pro_proveedores` ( 
    `proveedor_id` INT NOT NULL AUTO_INCREMENT , 
    `fk_par_tipo_persona` INT NOT NULL , 
    `fk_par_tipo_identificacion` INT NOT NULL , 
    `proveedor_identificacion` VARCHAR(20) NOT NULL , 
    `proveedor_nombre` VARCHAR(100) NULL , 
    `proveedor_apellido` VARCHAR(100) NULL , 
    `proveedor_razonsocial` VARCHAR(200) NULL , 
    `proveedor_celular` VARCHAR(10) NOT NULL , 
    `proveedor_correo` VARCHAR(100) NOT NULL , 
    `proveedor_ttodatos` VARCHAR(1) NOT NULL , 
    `proveedor_fttodatos` DATETIME NOT NULL , 
    `proveedor_fnacimiento` DATETIME NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`proveedor_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('4003', '4', 'Proveedores', '/proveedores/index', '1');

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220707_1636';