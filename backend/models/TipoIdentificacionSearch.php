<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TipoIdentificacion;

class TipoIdentificacionSearch extends TipoIdentificacion
{
    public function rules()
    {
        return [
            [['tipoiden_id', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['tipoiden_descripcion', 'fc', 'fm'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TipoIdentificacion::find();

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
            'tipoiden_id' => $this->tipoiden_id,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'tipoiden_descripcion', $this->tipoiden_descripcion]);

        return $dataProvider;
    }
}
