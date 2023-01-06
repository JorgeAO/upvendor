INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220210_2151');


CREATE TABLE `tb_seg_usuarios` ( 
    `usuarios_id` INT NOT NULL AUTO_INCREMENT , 
    `usuarios_nombre` VARCHAR(50) NOT NULL , 
    `usuarios_apellido` VARCHAR(50) NOT NULL , 
    `usuarios_telefono` VARCHAR(10) NOT NULL , 
    `usuarios_correo` VARCHAR(100) NOT NULL , 
    `usuarios_clave` VARCHAR(100) NOT NULL , 
    `usuarios_token` VARCHAR(100) NOT NULL , 
    `usuarios_vto_token` DATETIME NOT NULL , 
    `fk_seg_perfiles` INT NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`usuarios_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) VALUES ('1002', '1', 'Usuarios', '/usuarios/index', '1');


UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220210_2151';