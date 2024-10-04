<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Movimientos;

class MovimientosSearch extends Movimientos
{
    public function rules()
    {
        return [
            [['movimiento_id', 'fk_caj_tipo_movimiento', 'fk_caj_cajas', 'uc'], 'integer'],
            [['movimiento_fecha', 'fc', 'movimiento_observacion'], 'safe'],
            [['movimiento_monto'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Movimientos::find();

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
            'movimiento_id' => $this->movimiento_id,
            'movimiento_fecha' => $this->movimiento_fecha,
            'fk_caj_tipo_movimiento' => $this->fk_caj_tipo_movimiento,
            'fk_caj_cajas' => $this->fk_caj_cajas,
            'movimiento_monto' => $this->movimiento_monto,
            'fc' => $this->fc,
            'uc' => $this->uc,
        ]);

        $query->andFilterWhere(['like', 'movimiento_observacion', $this->movimiento_observacion]);

        return $dataProvider;
    }
}
