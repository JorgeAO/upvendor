<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoMovimiento;

class TipoMovimientoSearch extends TipoMovimiento
{
    public function rules()
    {
        return [
            [['tipomovi_id', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['tipomovi_descripcion', 'tipomovi_operacion', 'fc', 'fm'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TipoMovimiento::find();

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
            'tipomovi_id' => $this->tipomovi_id,
            'fk_par_estados' => $this->fk_par_estados,
            'tipomovi_operacion' => $this->tipomovi_operacion,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'tipomovi_descripcion', $this->tipomovi_descripcion]);

        return $dataProvider;
    }
}
