INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220707_1438');

CREATE TABLE `upvendor`.`tb_pro_marcas` ( 
    `marca_id` INT NOT NULL AUTO_INCREMENT , 
    `marca_descripcion` VARCHAR(100) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`marca_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('4002', '4', 'Marcas', '/marcas/index', '1');

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220707_1438';