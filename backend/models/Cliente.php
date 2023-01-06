<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_cli_cliente".
 *
 * @property int $cliente_id
 * @property int $fk_par_tipo_persona
 * @property int $fk_par_tipo_identificacion
 * @property string $cliente_identificacion
 * @property string $cliente_nombre
 * @property string $cliente_apellido
 * @property string $cliente_razonsocial
 * @property string $cliente_celular
 * @property string $cliente_correo
 * @property int $cliente_maxdiasmora
 * @property string $cliente_ttodatos
 * @property string $cliente_fttodatos
 * @property string $cliente_fnacimiento
 * @property string $cliente_pubcorreo
 * @property int $fk_par_estados
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_cli_cliente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'cliente_identificacion', 'cliente_celular', 'cliente_correo', 'cliente_maxdiasmora', 'cliente_ttodatos', 'cliente_pubcorreo'], 'required'],
            [['fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'cliente_maxdiasmora', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['cliente_fttodatos', 'cliente_fnacimiento', 'fc', 'fm'], 'safe'],
            [['cliente_identificacion'], 'string', 'max' => 20],
            [['cliente_nombre', 'cliente_apellido', 'cliente_correo'], 'string', 'max' => 100],
            [['cliente_razonsocial'], 'string', 'max' => 200],
            [['cliente_celular'], 'string', 'max' => 10],
            [['cliente_ttodatos', 'cliente_pubcorreo'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cliente_id' => 'Código',
            'fk_par_tipo_persona' => 'Tipo Persona',
            'fk_par_tipo_identificacion' => 'Tipo Identificación',
            'cliente_identificacion' => 'Identificación',
            'cliente_nombre' => 'Nombre',
            'cliente_apellido' => 'Apellido',
            'cliente_razonsocial' => 'Razón Social',
            'cliente_celular' => 'Celular',
            'cliente_correo' => 'Correo Electrónico',
            'cliente_maxdiasmora' => 'Máx. Días Mora',
            'cliente_ttodatos' => 'Acepta Tto. de Datos',
            'cliente_fttodatos' => 'Fecha Acepta Tto. de Datos',
            'cliente_fnacimiento' => 'Fecha Nacimiento',
            'cliente_pubcorreo' => 'Acepta Publicidad por Correo',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
