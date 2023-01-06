INSERT INTO `tb_seg_dba` (`dba_codigo`) VALUES ('20220214_2223');


INSERT INTO `tb_seg_opciones` (`opciones_id`, `fk_seg_modulos`, `opciones_nombre`, `opciones_enlace`, `fk_par_estados`) VALUES ('1003', '1', 'Permisos', '/permisos/index', '1');
INSERT INTO `tb_seg_permisos` (`permisos_id`, `fk_seg_perfiles`, `fk_seg_opciones`, `c`, `r`, `u`, `d`, `l`, `v`) VALUES (NULL, '1', '1003', '1', '1', '0', '0', '0', '0');


UPDATE `tb_seg_dba` SET `dba_ejecutado` = '1' WHERE `dba_codigo` = '20220214_2223';