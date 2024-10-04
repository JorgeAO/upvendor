<?php

namespace app\models;

use Yii;

class EstadosVenta extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_ven_estado_venta';
    }

    public function rules()
    {
        return [
            [['ventesta_descripcion'], 'required'],
            [['ventesta_descripcion'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ventesta_codigo' => 'Ventesta Codigo',
            'ventesta_descripcion' => 'Ventesta Descripcion',
        ];
    }
}
