INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220214_2223');


INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) VALUES ('1004', '1', 'Cambiar Clave', '/usuarios/cambiar-clave', '1');


UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220214_2223';