<?php

namespace app\models;

use Yii;

class Permisos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_seg_permisos';
    }

    public function rules()
    {
        return [
            [['fk_seg_perfiles', 'fk_seg_opciones'], 'required'],
            [['fk_seg_perfiles', 'fk_seg_opciones', 'c', 'r', 'u', 'd', 'l', 'v'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'permisos_id' => 'Código',
            'fk_seg_perfiles' => 'Perfil',
            'fk_seg_opciones' => 'Opción',
            'c' => 'Agregar',
            'r' => 'Consultar',
            'u' => 'Editar',
            'd' => 'Eliminar',
            'l' => 'Listar',
            'v' => 'Ver',
        ];
    }
}