<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proveedores;

/**
 * ProveedoresSearch represents the model behind the search form of `app\models\Proveedores`.
 */
class ProveedoresSearch extends Proveedores
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proveedor_id', 'fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['proveedor_identificacion', 'proveedor_nombre', 'proveedor_apellido', 'proveedor_razonsocial', 'proveedor_celular', 'proveedor_correo', 'proveedor_ttodatos', 'proveedor_fttodatos', 'proveedor_fnacimiento', 'fc', 'fm'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
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
            ->andFilterWhere(['like', 'proveedor_nombre', $this->proveedor_nombre])
            ->andFilterWhere(['like', 'proveedor_apellido', $this->proveedor_apellido])
            ->andFilterWhere(['like', 'proveedor_razonsocial', $this->proveedor_razonsocial])
            ->andFilterWhere(['like', 'proveedor_celular', $this->proveedor_celular])
            ->andFilterWhere(['like', 'proveedor_correo', $this->proveedor_correo])
            ->andFilterWhere(['like', 'proveedor_ttodatos', $this->proveedor_ttodatos]);

        return $dataProvider;
    }
}
