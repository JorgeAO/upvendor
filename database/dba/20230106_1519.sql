INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20230106_1519');

CREATE TABLE `upvendor`.`tb_pro_impuestos` (
    `impuesto_id` INT NOT NULL AUTO_INCREMENT , 
    `impuesto_descripcion` VARCHAR(50) NOT NULL , 
    `impuesto_porcentaje` DOUBLE NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`impuesto_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('4007', '4', 'Impuestos', '/impuestos/index', '1');

ALTER TABLE `tb_pro_productos` 
    ADD `producto_porc_imp` FLOAT NOT NULL AFTER `producto_precioventa`, 
    ADD `productos_precio_con_imp` FLOAT NOT NULL AFTER `producto_porc_imp`;

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20230106_1519';