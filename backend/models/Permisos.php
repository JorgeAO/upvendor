<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_seg_permisos".
 *
 * @property int $permisos_id
 * @property int $fk_seg_perfiles
 * @property int $fk_seg_opciones
 * @property int $c
 * @property int $r
 * @property int $u
 * @property int $d
 * @property int $l
 * @property int $v
 */
class Permisos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_seg_permisos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fk_seg_perfiles', 'fk_seg_opciones'], 'required'],
            [['fk_seg_perfiles', 'fk_seg_opciones', 'c', 'r', 'u', 'd', 'l', 'v'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'permisos_id' => 'Código',
            'fk_seg_perfiles' => 'Perfil',
            'fk_seg_opciones' => 'Opción',
            'c' => 'Agregar',
            'r' => 'Consultar',
            'u' => 'Editar',
            'd' => 'Eliminar',
            'l' => 'Listar',
            'v' => 'Ver',
        ];
    }
}