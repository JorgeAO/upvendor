<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pro_atributos_valor".
 *
 * @property int $atrivalor_id
 * @property int $fk_pro_atributos
 * @property string $atrivalor_valor
 * @property int $fk_par_estados
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class AtributosValor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_pro_atributos_valor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_pro_atributos', 'atrivalor_valor'], 'required'],
            [['fk_pro_atributos', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['atrivalor_valor'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'atrivalor_id' => 'Código',
            'fk_pro_atributos' => 'Atributo',
            'atrivalor_valor' => 'Valor',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
