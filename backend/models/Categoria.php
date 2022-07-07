<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pro_categorias".
 *
 * @property int $categoria_id
 * @property string $categoria_descripcion
 * @property int $fk_par_estados
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_pro_categorias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria_descripcion', 'fc', 'uc'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['categoria_descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'categoria_id' => 'Código',
            'categoria_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
