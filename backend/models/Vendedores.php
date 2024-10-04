<?php

namespace app\models;

use Yii;

class Vendedores extends \yii\db\ActiveRecord
{
    public $crear_usuario;

    public static function tableName()
    {
        return 'tb_ven_vendedores';
    }
    
    public function rules()
    {
        return [
            [['fk_par_tipo_identificacion', 'vendedor_identificacion', 'vendedor_nombre_completo', 'vendedor_correo_electronico', 'vendedor_telefono', 'vendedor_direccion'], 'required'],
            [['fk_par_tipo_identificacion', 'fk_seg_usuarios', 'fk_par_estados', 'uc', 'um', ], 'integer'],
            [['fc', 'fm'], 'safe'],
            [['vendedor_identificacion'], 'string', 'max' => 20],
            [['vendedor_nombre_completo'], 'string', 'max' => 200],
            [['vendedor_correo_electronico', 'vendedor_direccion'], 'string', 'max' => 100],
            [['vendedor_telefono'], 'string', 'max' => 10],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'vendedor_id' => 'Código',
            'fk_par_tipo_identificacion' => 'Tipo de Identificación',
            'vendedor_identificacion' => 'Identificación',
            'vendedor_nombre_completo' => 'Nombre Completo',
            'vendedor_correo_electronico' => 'Correo Electrónico',
            'vendedor_telefono' => 'Teléfono',
            'vendedor_direccion' => 'Dirección',
            'fk_seg_usuarios' => 'Usuario',
            'fk_par_estados' => 'Estado',
            'fc' => 'Fecha de Creación',
            'uc' => 'Usuario de Creación',
            'fm' => 'Fecha de Modificación',
            'um' => 'Usuario de Modificación',
        ];
    }
}
