<?php

namespace app\models;

use Yii;

class Productos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_pro_productos';
    }

    public function rules()
    {
        return [
            [['producto_nombre', 'producto_descripcion', 'producto_referencia', 'producto_stock', 'producto_preciocompra', 'producto_precioventa', 'producto_porc_imp', 'productos_precio_con_imp'], 'required'],
            [['fk_pro_categoria', 'producto_stock', 'producto_alertastock', 'fk_pro_marcas', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['producto_preciocompra', 'producto_precioventa', 'producto_porc_imp', 'productos_precio_con_imp'], 'number'],
            [['fc', 'fm'], 'safe'],
            [['producto_nombre'], 'string', 'max' => 100],
            [['producto_descripcion'], 'string', 'max' => 200],
            [['producto_referencia'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'producto_id' => 'Código',
            'producto_nombre' => 'Nombre',
            'producto_descripcion' => 'Descripción',
            'producto_referencia' => 'Referencia',
            'fk_pro_categoria' => 'Categoría',
            'producto_stock' => 'Cantidad en Stock',
            'producto_alertastock' => 'Alerta de Bajo Stock',
            'producto_preciocompra' => 'Precio de Compra',
            'producto_precioventa' => 'Precio de Venta Sin Impuestos',
            'producto_porc_imp' => 'Porcentaje de Impuestos',
            'productos_precio_con_imp' => 'Precio de Venta Con Impuestos',
            'fk_pro_marcas' => 'Marca',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
