INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220707_1403');

INSERT INTO `tb_seg_modulos` (`modulos_id`, `modulos_descripcion`, `modulos_prefijo`, `modulos_icono`, `fk_par_estados`, `fc`, `uc`, `fm`, `um`) 
VALUES (NULL, 'Productos', 'pro', 'boxes', '1', '0000-00-00 00:00:00', '0', NULL, NULL);

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('4001', '4', 'Categorías', '/categoria/index', '1');

CREATE TABLE `upvendor`.`tb_pro_categorias` ( 
    `categoria_id` INT NOT NULL AUTO_INCREMENT , 
    `categoria_descripcion` VARCHAR(100) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`categoria_id`)
) ENGINE = InnoDB;

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220707_1403';