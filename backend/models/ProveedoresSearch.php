<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proveedores;

class ProveedoresSearch extends Proveedores
{
    public function rules()
    {
        return [
            [['proveedor_id', 'fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [
                [
                    'proveedor_identificacion', 'proveedor_primer_nombre', 'proveedor_segundo_nombre', 'proveedor_primer_apellido', 'proveedor_segundo_apellido', 'proveedor_razonsocial', 'proveedor_nombrecompleto', 
                    'proveedor_celular', 'proveedor_correo', 'proveedor_direccion', 'proveedor_barrio', 'proveedor_ttodatos', 'proveedor_fttodatos', 'proveedor_fnacimiento', 'fc', 'fm'
                ],
                'safe'
            ],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Proveedores::find();

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
            'proveedor_id' => $this->proveedor_id,
            'fk_par_tipo_persona' => $this->fk_par_tipo_persona,
            'fk_par_tipo_identificacion' => $this->fk_par_tipo_identificacion,
            'proveedor_fttodatos' => $this->proveedor_fttodatos,
            'proveedor_fnacimiento' => $this->proveedor_fnacimiento,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'proveedor_identificacion', $this->proveedor_identificacion])
            ->andFilterWhere(['like', 'proveedor_primer_nombre', $this->proveedor_primer_nombre])
            ->andFilterWhere(['like', 'proveedor_segundo_nombre', $this->proveedor_segundo_nombre])
            ->andFilterWhere(['like', 'proveedor_primer_apellido', $this->proveedor_primer_apellido])
            ->andFilterWhere(['like', 'proveedor_segundo_apellido', $this->proveedor_segundo_apellido])
            ->andFilterWhere(['like', 'proveedor_razonsocial', $this->proveedor_razonsocial])
            ->andFilterWhere(['like', 'proveedor_nombrecompleto', $this->proveedor_nombrecompleto])
            ->andFilterWhere(['like', 'proveedor_celular', $this->proveedor_celular])
            ->andFilterWhere(['like', 'proveedor_correo', $this->proveedor_correo])
            ->andFilterWhere(['like', 'proveedor_direccion', $this->proveedor_direccion])
            ->andFilterWhere(['like', 'proveedor_barrio', $this->proveedor_barrio])
            ->andFilterWhere(['like', 'proveedor_ttodatos', $this->proveedor_ttodatos]);

        return $dataProvider;
    }
}
