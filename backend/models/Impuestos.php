<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pro_impuestos".
 *
 * @property int $impuesto_id
 * @property string $impuesto_descripcion
 * @property float $impuesto_porcentaje
 * @property int $fk_par_estados
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class Impuestos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_pro_impuestos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['impuesto_descripcion', 'impuesto_porcentaje'], 'required'],
            [['impuesto_porcentaje'], 'number'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['impuesto_descripcion'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'impuesto_id' => 'Código',
            'impuesto_descripcion' => 'Descripción',
            'impuesto_porcentaje' => 'Porcentaje',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
