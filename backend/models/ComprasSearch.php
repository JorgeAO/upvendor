<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Compras;

class ComprasSearch extends Compras
{
    public function rules()
    {
        return [
            [['compra_id', 'fk_pro_proveedores', 'fk_com_estados_compra', 'uc', 'um'], 'integer'],
            [['compra_fecha_compra', 'compra_fecha_confirmacion', 'compra_fecha_cierre', 'compra_fecha_anulacion', 'fc', 'fm'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Compras::find();

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
            'compra_id' => $this->compra_id,
            'fk_pro_proveedores' => $this->fk_pro_proveedores,
            'compra_fecha_compra' => $this->compra_fecha_compra,
            'fk_com_estados_compra' => $this->fk_com_estados_compra,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        return $dataProvider;
    }
}
