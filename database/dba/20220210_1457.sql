INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220210_1457');


CREATE TABLE `tb_seg_permisos` ( 
    `permisos_id` INT NOT NULL AUTO_INCREMENT , 
    `fk_seg_perfiles` INT NOT NULL , 
    `fk_seg_opciones` INT NOT NULL , 
    `c` INT NOT NULL DEFAULT '0' , 
    `r` INT NOT NULL DEFAULT '0' , 
    `u` INT NOT NULL DEFAULT '0' , 
    `d` INT NOT NULL DEFAULT '0' , 
    `l` INT NOT NULL DEFAULT '0' , 
    `v` INT NOT NULL DEFAULT '0' , 
    PRIMARY KEY (`permisos_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_seg_permisos` (`permisos_id`, `fk_seg_perfiles`, `fk_seg_opciones`, `c`, `r`, `u`, `d`, `l`, `v`) VALUES (NULL, '1', '1001', '1', '1', '1', '1', '1', '1');


UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220210_1457';