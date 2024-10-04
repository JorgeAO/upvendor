<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vendedores;

class VendedoresSearch extends Vendedores
{
    public function rules()
    {
        return [
            [['vendedor_id', 'fk_par_tipo_identificacion', 'fk_seg_usuarios', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['vendedor_identificacion', 'vendedor_nombre_completo', 'vendedor_correo_electronico', 'vendedor_telefono', 'vendedor_direccion', 'fc', 'fm'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Vendedores::find();

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
            'vendedor_id' => $this->vendedor_id,
            'fk_par_tipo_identificacion' => $this->fk_par_tipo_identificacion,
            'fk_seg_usuarios' => $this->fk_seg_usuarios,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'vendedor_identificacion', $this->vendedor_identificacion])
            ->andFilterWhere(['like', 'vendedor_nombre_completo', $this->vendedor_nombre_completo])
            ->andFilterWhere(['like', 'vendedor_correo_electronico', $this->vendedor_correo_electronico])
            ->andFilterWhere(['like', 'vendedor_telefono', $this->vendedor_telefono])
            ->andFilterWhere(['like', 'vendedor_direccion', $this->vendedor_direccion]);

        return $dataProvider;
    }
}
