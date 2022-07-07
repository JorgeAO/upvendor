INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220630_1114');

CREATE TABLE `upvendor`.`tb_par_tipo_persona` ( 
    `tipopers_id` INT NOT NULL AUTO_INCREMENT , 
    `tipopers_descripcion` VARCHAR(100) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME NULL , 
    `um` INT NULL , 
    PRIMARY KEY (`tipopers_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) VALUES ('2002', '2', 'Tipo de Persona', '/tipo-persona/index', '1');

UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220630_1114';