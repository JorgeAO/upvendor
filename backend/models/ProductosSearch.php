<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Productos;

/**
 * ProductosSearch represents the model behind the search form of `app\models\Productos`.
 */
class ProductosSearch extends Productos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'producto_stock', 'producto_alertastock', 'fk_pro_marcas', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['producto_nombre', 'producto_descripcion', 'producto_referencia', 'fc', 'fm'], 'safe'],
            [['producto_preciocompra', 'producto_precioventa'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Productos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'producto_id' => $this->producto_id,
            'producto_stock' => $this->producto_stock,
            'producto_alertastock' => $this->producto_alertastock,
            'producto_preciocompra' => $this->producto_preciocompra,
            'producto_precioventa' => $this->producto_precioventa,
            'fk_pro_marcas' => $this->fk_pro_marcas,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'producto_nombre', $this->producto_nombre])
            ->andFilterWhere(['like', 'producto_descripcion', $this->producto_descripcion])
            ->andFilterWhere(['like', 'producto_referencia', $this->producto_referencia]);

        return $dataProvider;
    }
}
