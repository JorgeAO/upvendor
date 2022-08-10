<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_com_estados_compra".
 *
 * @property int $compesta_id
 * @property string $compesta_descripcion
 */
class EstadosCompra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_com_estados_compra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['compesta_descripcion'], 'required'],
            [['compesta_descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'compesta_id' => 'Código',
            'compesta_descripcion' => 'Descripción',
        ];
    }
}
