<?php

namespace app\models;

use Yii;

class Atributos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_pro_atributos';
    }

    public function rules()
    {
        return [
            [['atributo_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['atributo_descripcion'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'atributo_id' => 'Código',
            'atributo_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
