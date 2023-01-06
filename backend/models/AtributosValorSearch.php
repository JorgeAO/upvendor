<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AtributosValor;

/**
 * AtributosValorSearch represents the model behind the search form of `app\models\AtributosValor`.
 */
class AtributosValorSearch extends AtributosValor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['atrivalor_id', 'fk_pro_atributos', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['atrivalor_valor', 'fc', 'fm'], 'safe'],
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
        $query = AtributosValor::find();

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
            'atrivalor_id' => $this->atrivalor_id,
            'fk_pro_atributos' => $this->fk_pro_atributos,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'atrivalor_valor', $this->atrivalor_valor]);

        return $dataProvider;
    }
}
