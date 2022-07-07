<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_par_tipo_persona".
 *
 * @property int $tipopers_id
 * @property string $tipopers_descripcion
 * @property int $fk_par_estados
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class TipoPersona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_par_tipo_persona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipopers_descripcion'], 'required'],
            [['fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['tipopers_descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tipopers_id' => 'Código',
            'tipopers_descripcion' => 'Descripción',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
