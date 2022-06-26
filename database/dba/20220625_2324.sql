INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220625_2324');


INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) VALUES ('1005', '1', 'Cambiar Clave de Usuario', '/usuarios/cambiar-clave-usuario', '1');


UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220625_2324';