<?php

namespace app\models;

use Yii;

class Marcas extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_pro_marcas';
    }

    public function rules()
    {
        return [
            [['marca_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['marca_descripcion'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'marca_id' => 'Código',
            'marca_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
