<?php

namespace app\models;

use Yii;

class Caja extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_caj_cajas';
    }

    public function rules()
    {
        return [
            [['caja_descripcion', 'caja_monto'], 'required'],
            [['caja_monto'], 'number'],
            [['fk_par_estado', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['caja_descripcion'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'caja_id' => 'Código',
            'caja_descripcion' => 'Descripción',
            'caja_monto' => 'Monto',
            'fk_par_estado' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
