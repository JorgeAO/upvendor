<?php

namespace app\models;

use Yii;

class Movimientos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_caj_movimientos';
    }

    public function rules()
    {
        return [
            [['movimiento_fecha', 'fk_caj_tipo_movimiento', 'fk_caj_cajas', 'movimiento_monto', 'fc', 'uc'], 'required'],
            [['movimiento_fecha', 'fc'], 'safe'],
            [['fk_caj_tipo_movimiento', 'fk_caj_cajas', 'uc'], 'integer'],
            [['movimiento_observacion'], 'string'],
            [['movimiento_monto'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'movimiento_id' => 'Código',
            'movimiento_observacion' => 'Observación',
            'movimiento_fecha' => 'Fecha',
            'fk_caj_tipo_movimiento' => 'Tipo de Movimiento',
            'fk_caj_cajas' => 'Caja',
            'movimiento_monto' => 'Monto',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
        ];
    }
}
