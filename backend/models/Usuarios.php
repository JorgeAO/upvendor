<?php

namespace app\models;

use Yii;

class Usuarios extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_seg_usuarios';
    }

    public function rules()
    {
        return [
            [['usuarios_nombre', 'usuarios_apellido', 'usuarios_telefono', 'usuarios_correo', 'usuarios_clave', 'fk_seg_perfiles'], 'required'],
            [['usuarios_vto_token', 'fc', 'fm'], 'safe'],
            [['fk_seg_perfiles', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['usuarios_nombre', 'usuarios_apellido'], 'string', 'max' => 50],
            [['usuarios_telefono'], 'string', 'max' => 10],
            [['usuarios_correo', 'usuarios_clave', 'usuarios_token'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'usuarios_id' => 'Código',
            'usuarios_nombre' => 'Nombre',
            'usuarios_apellido' => 'Apellido',
            'usuarios_telefono' => 'Teléfono',
            'usuarios_correo' => 'Correo Electrónico',
            'usuarios_clave' => 'Clave',
            'usuarios_token' => 'Token',
            'usuarios_vto_token' => 'Vencimiento del Token',
            'fk_seg_perfiles' => 'Perfil',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}