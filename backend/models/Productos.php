<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pro_productos".
 *
 * @property int $producto_id
 * @property string $producto_nombre
 * @property string $producto_descripcion
 * @property string $producto_referencia
 * @property int $producto_stock
 * @property int $producto_alertastock
 * @property float $producto_preciocompra
 * @property float $producto_precioventa
 * @property int|null $fk_pro_marcas
 * @property int $fk_par_estados
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_pro_productos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_nombre', 'producto_descripcion', 'producto_referencia', 'producto_stock', 'producto_preciocompra', 'producto_precioventa'], 'required'],
            [['producto_stock', 'producto_alertastock', 'fk_pro_marcas', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['producto_preciocompra', 'producto_precioventa'], 'number'],
            [['fc', 'fm'], 'safe'],
            [['producto_nombre'], 'string', 'max' => 100],
            [['producto_descripcion'], 'string', 'max' => 200],
            [['producto_referencia'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'producto_id' => 'Código',
            'producto_nombre' => 'Nombre',
            'producto_descripcion' => 'Descripción',
            'producto_referencia' => 'Referencia',
            'producto_stock' => 'Cantidad en Stock',
            'producto_alertastock' => 'Alerta de Bajo Stock',
            'producto_preciocompra' => 'Precio de Compra',
            'producto_precioventa' => 'Precio de Venta',
            'fk_pro_marcas' => 'Marca',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
