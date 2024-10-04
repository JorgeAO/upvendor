<?php

namespace app\models;

use Yii;

class EstadosCompra extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_com_estados_compra';
    }

    public function rules()
    {
        return [
            [['compesta_descripcion'], 'required'],
            [['compesta_descripcion'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'compesta_id' => 'Código',
            'compesta_descripcion' => 'Descripción',
        ];
    }
}
