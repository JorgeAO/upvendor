<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_par_estados".
 *
 * @property int $estados_id
 * @property string $estados_descripcion
 */
class Estados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_par_estados';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estados_descripcion'], 'required'],
            [['estados_descripcion'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estados_id' => 'Código',
            'estados_descripcion' => 'Descripción',
        ];
    }
}