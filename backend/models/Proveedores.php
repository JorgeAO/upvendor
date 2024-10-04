<?php

namespace app\models;

use Yii;

class Proveedores extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_pro_proveedores';
    }

    public function rules()
    {
        return [
            [['fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'proveedor_identificacion', 'proveedor_celular', 'proveedor_correo', 'proveedor_ttodatos', 'proveedor_fttodatos'], 'required'],
            [['fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['proveedor_fttodatos', 'proveedor_fnacimiento', 'fc', 'fm'], 'safe'],
            [['proveedor_identificacion'], 'string', 'max' => 20],
            [['proveedor_primer_nombre', 'proveedor_segundo_nombre', 'proveedor_primer_apellido', 'proveedor_segundo_apellido', 'proveedor_correo', 'proveedor_barrio'], 'string', 'max' => 100],
            [['proveedor_razonsocial', 'proveedor_nombrecompleto', 'proveedor_direccion'], 'string', 'max' => 200],
            [['proveedor_celular'], 'string', 'max' => 10],
            [['proveedor_ttodatos'], 'string', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'proveedor_id' => 'Código',
            'fk_par_tipo_persona' => 'Tipo Persona',
            'fk_par_tipo_identificacion' => 'Tipo Identificación',
            'proveedor_identificacion' => 'Identificación',
            'proveedor_primer_nombre' => 'Primer Nombre',
            'proveedor_segundo_nombre' => 'Segundo Nombre',
            'proveedor_primer_apellido' => 'Primer Apellido',
            'proveedor_segundo_apellido' => 'Segundo Apellido',
            'proveedor_razonsocial' => 'Razón Social',
            'proveedor_nombrecompleto' => 'Nombre Completo',
            'proveedor_celular' => 'Celular',
            'proveedor_correo' => 'Correo Electrónico',
            'proveedor_direccion' => 'Dirección',
            'proveedor_barrio' => 'Barrio',
            'proveedor_ttodatos' => 'Acepta Tto. de Datos',
            'proveedor_fttodatos' => 'Fecha Acepta Tto. de Datos',
            'proveedor_fnacimiento' => 'Fecha Nacimiento',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
