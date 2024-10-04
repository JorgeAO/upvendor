<?php

namespace app\models;

use Yii;

class VentasProductos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_ven_ventas_productos';
    }
    
    public function rules()
    {
        return [
            [['fk_ven_ventas', 'fk_pro_productos', 'ventprod_cantidad', 'ventprod_vlr_unitario', 'ventprod_vlr_total', 'ventprod_dcto', 'ventprod_vlr_final', 'fc', 'uc'], 'required'],
            [['fk_ven_ventas', 'fk_pro_productos', 'ventprod_cantidad', 'uc', 'um'], 'integer'],
            [['ventprod_vlr_unitario', 'ventprod_vlr_total', 'ventprod_dcto', 'ventprod_vlr_final'], 'number'],
            [['fc', 'fm'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'ventprod_id' => 'Código',
            'fk_ven_ventas' => 'Venta',
            'fk_pro_productos' => 'Producto',
            'ventprod_cantidad' => 'Cantidad',
            'ventprod_vlr_unitario' => 'Valor Unitario',
            'ventprod_vlr_total' => 'Valor Total',
            'ventprod_dcto' => 'Descuento',
            'ventprod_vlr_final' => 'Valor Final',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
