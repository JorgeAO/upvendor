<?php

namespace app\models;

use Yii;

class Perfiles extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_seg_perfiles';
    }

    public function rules()
    {
        return [
            [['perfiles_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['perfiles_descripcion'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'perfiles_id' => 'Código',
            'perfiles_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}