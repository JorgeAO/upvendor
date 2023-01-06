<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cliente;

/**
 * ClienteSearch represents the model behind the search form of `app\models\Cliente`.
 */
class ClienteSearch extends Cliente
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cliente_id', 'fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'cliente_maxdiasmora', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['cliente_identificacion', 'cliente_nombre', 'cliente_apellido', 'cliente_razonsocial', 'cliente_celular', 'cliente_correo', 'cliente_ttodatos', 'cliente_fttodatos', 'cliente_fnacimiento', 'cliente_pubcorreo', 'fc', 'fm'], 'safe'],
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
        $query = Cliente::find();

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
            'cliente_id' => $this->cliente_id,
            'fk_par_tipo_persona' => $this->fk_par_tipo_persona,
            'fk_par_tipo_identificacion' => $this->fk_par_tipo_identificacion,
            'cliente_maxdiasmora' => $this->cliente_maxdiasmora,
            'cliente_fttodatos' => $this->cliente_fttodatos,
            'cliente_fnacimiento' => $this->cliente_fnacimiento,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'cliente_identificacion', $this->cliente_identificacion])
            ->andFilterWhere(['like', 'cliente_nombre', $this->cliente_nombre])
            ->andFilterWhere(['like', 'cliente_apellido', $this->cliente_apellido])
            ->andFilterWhere(['like', 'cliente_razonsocial', $this->cliente_razonsocial])
            ->andFilterWhere(['like', 'cliente_celular', $this->cliente_celular])
            ->andFilterWhere(['like', 'cliente_correo', $this->cliente_correo])
            ->andFilterWhere(['like', 'cliente_ttodatos', $this->cliente_ttodatos])
            ->andFilterWhere(['like', 'cliente_pubcorreo', $this->cliente_pubcorreo]);

        return $dataProvider;
    }
}
