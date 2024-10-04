<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Caja;

class CajaSearch extends Caja
{
    public function rules()
    {
        return [
            [['caja_id', 'fk_par_estado', 'uc', 'um'], 'integer'],
            [['caja_descripcion', 'fc', 'fm'], 'safe'],
            [['caja_monto'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Caja::find();

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
            'caja_id' => $this->caja_id,
            'caja_monto' => $this->caja_monto,
            'fk_par_estado' => $this->fk_par_estado,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'caja_descripcion', $this->caja_descripcion]);

        return $dataProvider;
    }
}
