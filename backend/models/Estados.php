<?php

namespace app\models;

use Yii;

class Estados extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_par_estados';
    }

    public function rules()
    {
        return [
            [['estados_descripcion'], 'required'],
            [['estados_descripcion'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'estados_id' => 'Código',
            'estados_descripcion' => 'Descripción',
        ];
    }
}