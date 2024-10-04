<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ventas;

class VentasSearch extends Ventas
{
    public function rules()
    {
        return [
            [['venta_id', 'fk_cli_cliente', 'venta_fecha_venta', 'fk_ven_estado_venta', 'uc', 'um'], 'integer'],
            [['fc', 'fm'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Ventas::find();

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
            'venta_id' => $this->venta_id,
            'fk_cli_cliente' => $this->fk_cli_cliente,
            'venta_fecha_venta' => $this->venta_fecha_venta,
            'fk_ven_estado_venta' => $this->fk_ven_estado_venta,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        return $dataProvider;
    }
}
