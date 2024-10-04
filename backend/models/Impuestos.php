<?php

namespace app\models;

use Yii;

class Impuestos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_pro_impuestos';
    }

    public function rules()
    {
        return [
            [['impuesto_descripcion', 'impuesto_porcentaje'], 'required'],
            [['impuesto_porcentaje'], 'number'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['impuesto_descripcion'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'impuesto_id' => 'Código',
            'impuesto_descripcion' => 'Descripción',
            'impuesto_porcentaje' => 'Porcentaje',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
