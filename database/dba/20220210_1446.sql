INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220210_1446');


CREATE TABLE `tb_seg_modulos` ( 
    `modulos_id` INT NOT NULL AUTO_INCREMENT , 
    `modulos_descripcion` VARCHAR(50) NOT NULL , 
    `modulos_prefijo` VARCHAR(3) NOT NULL , 
    `modulos_icono` VARCHAR(10) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`modulos_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_modulos` (`modulos_id`, `modulos_descripcion`, `modulos_prefijo`, `modulos_icono`, `fk_par_estados`, `fc`, `uc`, `fm`, `um`) VALUES ('1', 'Seguridad', 'seg', 'shield-alt', '1', '', '', NULL, NULL);
INSERT INTO `tb_seg_modulos` (`modulos_id`, `modulos_descripcion`, `modulos_prefijo`, `modulos_icono`, `fk_par_estados`, `fc`, `uc`, `fm`, `um`) VALUES ('2', 'Parámetros', 'par', 'sliders', '1', '', '', NULL, NULL);

CREATE TABLE `tb_seg_opciones` ( 
    `opciones_id` INT NOT NULL AUTO_INCREMENT , 
    `fk_seg_modulos` INT NOT NULL , 
    `opciones_nombre` VARCHAR(100) NOT NULL , 
    `opciones_enlace` VARCHAR(50) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    PRIMARY KEY (`opciones_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) VALUES ('1001', '1', 'Perfiles', '/perfiles/index', '1');


UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220210_1446';