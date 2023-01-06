<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoPersona;

/**
 * TipoPersonaSearch represents the model behind the search form of `app\models\TipoPersona`.
 */
class TipoPersonaSearch extends TipoPersona
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipopers_id', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['tipopers_descripcion', 'fc', 'fm'], 'safe'],
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
        $query = TipoPersona::find();

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
            'tipopers_id' => $this->tipopers_id,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'tipopers_descripcion', $this->tipopers_descripcion]);

        return $dataProvider;
    }
}
