<?php

namespace app\models;

use Yii;

class Cliente extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_cli_cliente';
    }

    public function rules()
    {
        return [
            [['fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'cliente_identificacion', 'cliente_celular', 'cliente_correo', 'cliente_maxdiasmora', 'cliente_ttodatos', 'cliente_pubcorreo'], 'required'],
            [['fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'cliente_maxdiasmora', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['cliente_fttodatos', 'cliente_fnacimiento', 'fc', 'fm'], 'safe'],
            [['cliente_identificacion'], 'string', 'max' => 20],
            [['cliente_primer_nombre', 'cliente_segundo_nombre', 'cliente_primer_apellido', 'cliente_segundo_apellido', 'cliente_correo', 'cliente_direccion', 'cliente_barrio'], 'string', 'max' => 100],
            [['cliente_razonsocial', 'cliente_nombre_completo'], 'string', 'max' => 200],
            [['cliente_celular'], 'string', 'max' => 10],
            [['cliente_ttodatos', 'cliente_pubcorreo'], 'string', 'max' => 1],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'cliente_id' => 'Código',
            'fk_par_tipo_persona' => 'Tipo Persona',
            'fk_par_tipo_identificacion' => 'Tipo Identificación',
            'cliente_identificacion' => 'Identificación',
            'cliente_primer_nombre' => 'Primer Nombre',
            'cliente_segundo_nombre' => 'Segundo Nombre',
            'cliente_primer_apellido' => 'Primer Apellido',
            'cliente_segundo_apellido' => 'Segundo Apellido',
            'cliente_razonsocial' => 'Razón Social',
            'cliente_nombre_completo' => 'Nombre Completo',
            'cliente_celular' => 'Celular',
            'cliente_correo' => 'Correo Electrónico',
            'cliente_direccion' => 'Dirección',
            'cliente_barrio' => 'Barrio',
            'cliente_maxdiasmora' => 'Máx. Días Mora',
            'cliente_ttodatos' => 'Acepta Tto. de Datos',
            'cliente_fttodatos' => 'Fecha Acepta Tto. de Datos',
            'cliente_fnacimiento' => 'Fecha Nacimiento',
            'cliente_pubcorreo' => 'Acepta Publicidad por Correo',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
