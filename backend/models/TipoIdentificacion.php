<?php

namespace app\models;

use Yii;

class TipoIdentificacion extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_par_tipo_identificacion';
    }

    public function rules()
    {
        return [
            [['tipoiden_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['tipoiden_descripcion'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tipoiden_id' => 'Código',
            'tipoiden_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
