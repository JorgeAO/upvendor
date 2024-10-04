<?php

namespace app\models;

use Yii;

class Ventas extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_ven_ventas';
    }
    
    public function rules()
    {
        return [
            [['fk_cli_cliente', 'venta_fecha_venta', 'fk_ven_vendedor'], 'required'],
            [['venta_id', 'fk_par_forma_pago', 'fk_ven_estado_venta', 'uc', 'um'], 'integer'],
            [['venta_observacion'], 'string'],
            [['venta_fecha_venta', 'fc', 'fm'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'venta_id' => 'Venta',
            'fk_cli_cliente' => 'Cliente',
            'venta_fecha_venta' => 'Fecha Venta',
            'fk_par_forma_pago' => 'Forma de Pago',
            'fk_ven_vendedor' => 'Vendedor',
            'fk_ven_estado_venta' => 'Estado Venta',
            'venta_observacion' => 'Observación',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
