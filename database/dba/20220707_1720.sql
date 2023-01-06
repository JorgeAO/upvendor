INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220707_1720');

CREATE TABLE `upvendor`.`tb_pro_atributos` ( 
    `atributo_id` INT NOT NULL AUTO_INCREMENT , 
    `atributo_descripcion` VARCHAR(100) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`atributo_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('4005', '4', 'Atributos', '/atributos/index', '1');

CREATE TABLE `upvendor`.`tb_pro_atributos_valor` ( 
    `atrivalor_id` INT NOT NULL AUTO_INCREMENT , 
    `fk_pro_atributos` INT NOT NULL , 
    `atrivalor_valor` VARCHAR(100) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`atrivalor_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('4006', '4', 'Valores de Atributos', '/atributos-valores/index', '1');

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220707_1720';