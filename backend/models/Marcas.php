<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pro_marcas".
 *
 * @property int $marca_id
 * @property string $marca_descripcion
 * @property int $fk_par_estados
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class Marcas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_pro_marcas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['marca_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['marca_descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'marca_id' => 'Código',
            'marca_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
