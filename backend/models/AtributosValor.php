<?php

namespace app\models;

use Yii;

class AtributosValor extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_pro_atributos_valor';
    }

    public function rules()
    {
        return [
            [['fk_pro_atributos', 'atrivalor_valor'], 'required'],
            [['fk_pro_atributos', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['atrivalor_valor'], 'string', 'max' => 100],
        ];
    }

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
