<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_pro_proveedores".
 *
 * @property int $proveedor_id
 * @property int $fk_par_tipo_persona
 * @property int $fk_par_tipo_identificacion
 * @property string $proveedor_identificacion
 * @property string|null $proveedor_nombre
 * @property string|null $proveedor_apellido
 * @property string|null $proveedor_razonsocial
 * @property string $proveedor_celular
 * @property string $proveedor_correo
 * @property string $proveedor_ttodatos
 * @property string $proveedor_fttodatos
 * @property string|null $proveedor_fnacimiento
 * @property int $fk_par_estados
 * @property string $fc
 * @property int $uc
 * @property string|null $fm
 * @property int|null $um
 */
class Proveedores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_pro_proveedores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'proveedor_identificacion', 'proveedor_celular', 'proveedor_correo', 'proveedor_ttodatos', 'proveedor_fttodatos'], 'required'],
            [['fk_par_tipo_persona', 'fk_par_tipo_identificacion', 'fk_par_estados', 'uc', 'um'], 'integer'],
            [['proveedor_fttodatos', 'proveedor_fnacimiento', 'fc', 'fm'], 'safe'],
            [['proveedor_identificacion'], 'string', 'max' => 20],
            [['proveedor_nombre', 'proveedor_apellido', 'proveedor_correo'], 'string', 'max' => 100],
            [['proveedor_razonsocial', 'proveedor_nombrecompleto'], 'string', 'max' => 200],
            [['proveedor_celular'], 'string', 'max' => 10],
            [['proveedor_ttodatos'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'proveedor_id' => 'Código',
            'fk_par_tipo_persona' => 'Tipo Persona',
            'fk_par_tipo_identificacion' => 'Tipo Identificación',
            'proveedor_identificacion' => 'Identificación',
            'proveedor_nombre' => 'Nombre',
            'proveedor_apellido' => 'Apellido',
            'proveedor_razonsocial' => 'Razón Social',
            'proveedor_nombrecompleto' => 'Nombre Completo',
            'proveedor_celular' => 'Celular',
            'proveedor_correo' => 'Correo Electrónico',
            'proveedor_ttodatos' => 'Acepta Tto. de Datos',
            'proveedor_fttodatos' => 'Fecha Acepta Tto. de Datos',
            'proveedor_fnacimiento' => 'Fecha Nacimiento',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha Creación',
            'uc' => 'Usuario Creación',
            'fm' => 'Fecha Modificación',
            'um' => 'Usuario Modificación',
        ];
    }
}
