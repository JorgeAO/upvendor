INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220628_0548');

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) 
VALUES ('2001', '2', 'Tipo de Identificación', '/parametros/tipo-identificacion/index', '1');

CREATE TABLE `upvendor`.`tb_par_tipo_identificacion` ( 
    `tipoiden_id` INT NOT NULL AUTO_INCREMENT , 
    `tipoiden_descripcion` VARCHAR(100) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`tipoiden_id`)
) ENGINE = InnoDB;

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220628_0548';