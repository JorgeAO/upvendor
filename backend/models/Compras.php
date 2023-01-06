<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_com_compras".
 *
 * @property int $compra_id
 * @property int $fk_pro_proveedores
 * @property string $compra_fecha_compra
 * @property string|null $compra_fecha_confirmacion
 * @property string $compra_fecha_cierre
 * @property string|null $compra_fecha_anulacion
 * @property int $fk_com_estados_compra
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class Compras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_com_compras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_pro_proveedores', 'compra_fecha_compra'], 'required'],
            [['fk_com_estados_compra', 'uc', 'um'], 'integer'],
            [['compra_fecha_compra', 'compra_fecha_confirmacion', 'compra_fecha_cierre', 'compra_fecha_anulacion', 'fc', 'fm'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'compra_id' => 'Código',
            'fk_pro_proveedores' => 'Proveedor',
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
