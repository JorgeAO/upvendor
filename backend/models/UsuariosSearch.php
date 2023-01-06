<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;

/**
 * UsuariosSearch represents the model behind the search form of `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuarios_id', 'fk_seg_perfiles', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['usuarios_nombre', 'usuarios_apellido', 'usuarios_telefono', 'usuarios_correo', 'usuarios_clave', 'usuarios_token', 'usuarios_vto_token', 'fc', 'fm'], 'safe'],
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
        $query = Usuarios::find();

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
            'usuarios_id' => $this->usuarios_id,
            'usuarios_vto_token' => $this->usuarios_vto_token,
            'fk_seg_perfiles' => $this->fk_seg_perfiles,
            'fk_par_estados' => $this->fk_par_estados,
            'fc' => $this->fc,
            'uc' => $this->uc,
            'fm' => $this->fm,
            'um' => $this->um,
        ]);

        $query->andFilterWhere(['like', 'usuarios_nombre', $this->usuarios_nombre])
            ->andFilterWhere(['like', 'usuarios_apellido', $this->usuarios_apellido])
            ->andFilterWhere(['like', 'usuarios_telefono', $this->usuarios_telefono])
            ->andFilterWhere(['like', 'usuarios_correo', $this->usuarios_correo])
            ->andFilterWhere(['like', 'usuarios_clave', $this->usuarios_clave])
            ->andFilterWhere(['like', 'usuarios_token', $this->usuarios_token]);

        return $dataProvider;
    }
}