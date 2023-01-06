<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pro_productos_atributos".
 *
 * @property int $prodatri_id
 * @property int $fk_pro_productos
 * @property int $fk_pro_atributos
 * @property int $fk_pro_atributos_valor
 * @property string $fc
 * @property int $uc
 */
class ProductosAtributos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_pro_productos_atributos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_pro_productos', 'fk_pro_atributos', 'fk_pro_atributos_valor'], 'required'],
            [['fk_pro_productos', 'fk_pro_atributos', 'fk_pro_atributos_valor', 'uc'], 'integer'],
            [['fc'], 'safe'],
            [['fk_pro_productos', 'fk_pro_atributos', 'fk_pro_atributos_valor'], 'unique', 'targetAttribute' => ['fk_pro_productos', 'fk_pro_atributos', 'fk_pro_atributos_valor']],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
