<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Impuestos;

/**
 * ImpuestosSearch represents the model behind the search form of `app\models\Impuestos`.
 */
class ImpuestosSearch extends Impuestos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['impuesto_id', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['impuesto_descripcion', 'fc', 'fm'], 'safe'],
            [['impuesto_porcentaje'], 'number'],
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
        $query = Impuestos::find();

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
            'impuesto_id' => $this->impuesto_id,
            'impuesto_porcentaje' => $this->impuesto_porcentaje,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'impuesto_descripcion', $this->impuesto_descripcion]);

        return $dataProvider;
    }
}
