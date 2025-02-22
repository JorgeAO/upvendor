<?php

namespace app\models;

use Yii;

class Compras extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_com_compras';
    }

    public function rules()
    {
        return [
            [['fk_pro_proveedores', 'compra_fecha_compra', 'fk_par_forma_pago'], 'required'],
            [['fk_com_estados_compra', 'uc', 'um'], 'integer'],
            [['compra_fecha_compra', 'compra_fecha_confirmacion', 'compra_fecha_cierre', 'compra_fecha_anulacion', 'fc', 'fm'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'compra_id' => 'Código',
            'fk_pro_proveedores' => 'Proveedor',
            'fk_par_forma_pago' => 'Forma Pago',
            'compra_fecha_compra' => 'Fecha Compra',
            'compra_fecha_confirmacion' => 'Fecha Confirmación',
            'compra_fecha_cierre' => 'Fecha Cierre',
            'compra_fecha_anulacion' => 'Fecha Anulación',
            'fk_com_estados_compra' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
