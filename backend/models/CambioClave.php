<?php

namespace app\models;

use Yii;

class CambioClave extends yii\db\ActiveRecord
{
    public $usuarios_id;
    public $usuarios_clave;
    public $usuarios_nuevaclave;
    public $usuarios_repnuevaclave;

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuarios_id' => 'Código',
            'usuarios_clave' => 'Clave Actual',
            'usuarios_nuevaclave' => 'Nueva Clave',
            'usuarios_repnuevaclave' => 'Repetir Nueva Clave',
        ];
    }
}

?>