<?php

namespace app\models;

use Yii;

class TipoMovimiento extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_caj_tipo_movimiento';
    }

    public function rules()
    {
        return [
            [['tipomovi_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['tipomovi_descripcion'], 'string', 'max' => 50],
            [['tipomovi_operacion'], 'string', 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tipomovi_id' => 'Código',
            'tipomovi_descripcion' => 'Descripción',
            'tipomovi_operacion' => 'Operación',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
