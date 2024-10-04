<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Permisos;

class PermisosSearch extends Permisos
{
    public function rules()
    {
        return [
            [['permisos_id', 'fk_seg_perfiles', 'fk_seg_opciones', 'c', 'r', 'u', 'd', 'l', 'v'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Permisos::find();

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
            'permisos_id' => $this->permisos_id,
            'fk_seg_perfiles' => $this->fk_seg_perfiles,
            'fk_seg_opciones' => $this->fk_seg_opciones,
            'c' => $this->c,
            'r' => $this->r,
            'u' => $this->u,
            'd' => $this->d,
            'l' => $this->l,
            'v' => $this->v,
        ]);

        return $dataProvider;
    }
}