<?php

namespace app\models;

use Yii;

class ComprasProductos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_com_compras_productos';
    }

    public function rules()
    {
        return [
            [['fk_com_compras', 'fk_pro_productos', 'comprod_cantidad', 'comprod_vlr_unitario', 'comprod_vlr_total', 'comprod_dcto', 'comprod_vlr_final', 'comprod_entregado', 'fc', 'uc'], 'required'],
            [['fk_com_compras', 'fk_pro_productos', 'comprod_cantidad', 'comprod_entregado', 'uc', 'um'], 'integer'],
            [['comprod_vlr_unitario', 'comprod_vlr_total', 'comprod_dcto', 'comprod_vlr_final'], 'number'],
            [['fc', 'fm'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'comprod_id' => 'Comprod ID',
            'fk_com_compras' => 'Fk Com Compras',
            'fk_pro_productos' => 'Fk Pro Productos',
            'comprod_cantidad' => 'Comprod Cantidad',
            'comprod_vlr_unitario' => 'Comprod Vlr Unitario',
            'comprod_vlr_total' => 'Comprod Vlr Total',
            'comprod_dcto' => 'Comprod Dcto',
            'comprod_vlr_final' => 'Comprod Vlr Final',
            'comprod_entregado' => 'Comprod Entregado',
            'fc' => 'Fc',
            'uc' => 'Uc',
            'fm' => 'Fm',
            'um' => 'Um',
        ];
    }
}
