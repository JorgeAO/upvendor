<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Perfiles;

class PerfilesSearch extends Perfiles
{
    public function rules()
    {
        return [
            [['perfiles_id', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['perfiles_descripcion', 'fc', 'fm'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Perfiles::find();

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
            'perfiles_id' => $this->perfiles_id,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'perfiles_descripcion', $this->perfiles_descripcion]);

        return $dataProvider;
    }
}