<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categoria;

class CategoriaSearch extends Categoria
{
    public function rules()
    {
        return [
            [['categoria_id', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['categoria_descripcion', 'fc', 'fm'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Categoria::find();

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
            'categoria_id' => $this->categoria_id,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'categoria_descripcion', $this->categoria_descripcion]);

        return $dataProvider;
    }
}
