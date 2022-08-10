INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220714_1406');

ALTER TABLE `tb_seg_modulos` CHANGE `modulos_icono` `modulos_icono` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

INSERT INTO `tb_seg_modulos` (`modulos_id`, `modulos_descripcion`, `modulos_prefijo`, `modulos_icono`, `fk_par_estados`, `fc`, `uc`, `fm`, `um`) 
VALUES ('5', 'Compras', 'com', 'cart-arrow-down', '1', '0000-00-00 00:00:00', '0', NULL, NULL);

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('5001', '5', 'Compras', '/compras/index', '1');

CREATE TABLE `upvendor`.`tb_com_estados_compra` ( 
    `compesta_id` INT NOT NULL AUTO_INCREMENT , 
    `compesta_descripcion` VARCHAR(100) NOT NULL , 
    PRIMARY KEY (`compesta_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_com_estados_compra` (`compesta_id`, `compesta_descripcion`) 
VALUES 
    ('1', 'Borrador'), 
    ('2', 'Enviada'), 
    ('3', 'Confirmada'), 
    ('4', 'Anulada'), 
    ('5', 'Cerrada');

CREATE TABLE `upvendor`.`tb_com_compras` ( 
    `compra_id` INT NOT NULL AUTO_INCREMENT , 
    `fk_pro_proveedores` INT NOT NULL , 
    `compra_fecha_compra` DATETIME NOT NULL , 
    `compra_fecha_confirmacion` DATETIME NULL , 
    `compra_fecha_cierre` DATETIME NOT NULL , 
    `compra_fecha_anulacion` DATETIME NULL , 
    `fk_com_estados_compra` INT NOT NULL , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`compra_id`)
) ENGINE = InnoDB;

ALTER TABLE `tb_pro_proveedores` ADD `proveedor_nombrecompleto` VARCHAR(200) NOT NULL AFTER `proveedor_razonsocial`;

CREATE TABLE `upvendor`.`tb_com_compras_productos` ( 
    `comprod_id` INT NOT NULL AUTO_INCREMENT , 
    `fk_com_compras` INT NOT NULL , 
    `fk_pro_productos` INT NOT NULL , 
    `comprod_cantidad` INT NOT NULL , 
    `comprod_vlr_unitario` FLOAT NOT NULL , 
    `comprod_vlr_total` FLOAT NOT NULL , 
    `comprod_dcto` FLOAT NOT NULL , 
    `comprod_vlr_final` FLOAT NOT NULL , 
    `comprod_entregado` INT NOT NULL , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`comprod_id`)
) ENGINE = InnoDB;

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220714_1406';