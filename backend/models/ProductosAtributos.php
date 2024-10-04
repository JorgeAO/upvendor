<?php

namespace app\models;

use Yii;

class ProductosAtributos extends \yii\db\ActiveRecord
{
    public $atributo_descripcion;
    public $atrivalor_valor;

    public static function tableName()
    {
        return 'tb_pro_productos_atributos';
    }

    public function rules()
    {
        return [
            [['fk_pro_productos', 'fk_pro_atributos', 'fk_pro_atributos_valor'], 'required'],
            [['fk_pro_productos', 'fk_pro_atributos', 'fk_pro_atributos_valor', 'uc'], 'integer'],
            [['fc'], 'safe'],
            [['fk_pro_productos', 'fk_pro_atributos', 'fk_pro_atributos_valor'], 'unique', 'targetAttribute' => ['fk_pro_productos', 'fk_pro_atributos', 'fk_pro_atributos_valor']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'prodatri_id' => 'Código',
            'fk_pro_productos' => 'Producto',
            'fk_pro_atributos' => 'Atributo',
            'fk_pro_atributos_valor' => 'Valor',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
        ];
    }
}
