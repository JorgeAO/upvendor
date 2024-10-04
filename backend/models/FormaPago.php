<?php

namespace app\models;

use Yii;

class FormaPago extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_par_forma_pago';
    }

    public function rules()
    {
        return [
            [['formpago_descripcion'], 'required'],
            [['fk_caj_cajas', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['formpago_descripcion'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'formpago_id' => 'Código',
            'formpago_descripcion' => 'Descripción',
            'fk_caj_cajas' => 'Caja',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
