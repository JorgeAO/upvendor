INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220210_1306');


CREATE TABLE `tb_par_estados` ( 
    `estados_id` INT NOT NULL AUTO_INCREMENT , 
    `estados_descripcion` VARCHAR(20) NOT NULL , 
    PRIMARY KEY (`estados_id`)
) ENGINE = InnoDB;

INSERT INTO `tb_par_estados` (`estados_descripcion`) 
VALUES ('Activo'), ('Inactivo');


UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220210_1306';