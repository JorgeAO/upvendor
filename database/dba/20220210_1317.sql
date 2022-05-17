INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220210_1317');


CREATE TABLE `tb_seg_perfiles` (
    `perfiles_id` INT NOT NULL AUTO_INCREMENT , 
    `perfiles_descripcion` VARCHAR(50) NOT NULL , 
    `fk_par_estados` INT NOT NULL DEFAULT '1' , 
    `fc` DATETIME NOT NULL , 
    `uc` INT NOT NULL , 
    `fm` DATETIME , 
    `um` INT , 
    PRIMARY KEY (`perfiles_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_perfiles` (`perfiles_descripcion`, `fk_par_estados`, `fc`, `uc`, `fm`, `um`) VALUES ('Root', '1', '', '', NULL, NULL);
INSERT INTO `tb_seg_perfiles` (`perfiles_descripcion`, `fk_par_estados`, `fc`, `uc`, `fm`, `um`) VALUES ('Administrador', '1', '', '', NULL, NULL);


UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220210_1317';