<?php

namespace app\models;

use Yii;

class TipoPersona extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_par_tipo_persona';
    }

    public function rules()
    {
        return [
            [['tipopers_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['tipopers_descripcion'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tipopers_id' => 'Código',
            'tipopers_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
