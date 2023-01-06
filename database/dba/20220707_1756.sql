INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220707_1756');

CREATE TABLE `upvendor`.`tb_pro_productos` ( 
    `producto_id` INT NOT NULL AUTO_INCREMENT , 
    `producto_nombre` VARCHAR(100) NOT NULL , 
    `producto_descripcion` VARCHAR(200) NOT NULL , 
    `producto_referencia` VARCHAR(50) NOT NULL , 
    `producto_stock` INT NOT NULL , 
    `producto_alertastock` INT NOT NULL DEFAULT '0' , 
    `producto_preciocompra` FLOAT NOT NULL , 
    `producto_precioventa` FLOAT NOT NULL , 
    `fk_pro_marcas` INT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL ,
    PRIMARY KEY (`producto_id`)
) ENGINE = InnoDB;

CREATE TABLE `upvendor`.`tb_pro_productos_atributos` ( 
    `prodatri_id` INT NOT NULL AUTO_INCREMENT , 
    `fk_pro_productos` INT NOT NULL , 
    `fk_pro_atributos` INT NOT NULL , 
    `fk_pro_atributos_valor` INT NOT NULL , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    PRIMARY KEY (`prodatri_id`)
) ENGINE = InnoDB;

ALTER TABLE `tb_pro_productos_atributos` ADD UNIQUE(`fk_pro_productos`, `fk_pro_atributos`, `fk_pro_atributos_valor`);

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('4004', '4', 'Productos', '/productos/index', '1');

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220707_1756';