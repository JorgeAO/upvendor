CREATE TABLE `tb_seg_dba` ( 
    `dba_id` INT NOT NULL AUTO_INCREMENT , 
    `dba_codigo` VARCHAR(15) NOT NULL , 
    `dba_ejecutado` INT NOT NULL DEFAULT '0' , 
    PRIMARY KEY (`dba_id`)
) ENGINE = InnoDB;