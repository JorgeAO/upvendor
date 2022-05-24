<?php

namespace app\models;

use Yii;

class CambioClave extends yii\db\ActiveRecord
{
    public $usuarios_id;
    public $usuarios_clave;
    public $usuarios_nuevaclave;
    public $usuarios_repnuevaclave;
}

?>