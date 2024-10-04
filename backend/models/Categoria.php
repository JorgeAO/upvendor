<?php

namespace app\models;

use Yii;

class Categoria extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_pro_categorias';
    }

    public function rules()
    {
        return [
            [['categoria_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['categoria_descripcion'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'categoria_id' => 'Código',
            'categoria_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
