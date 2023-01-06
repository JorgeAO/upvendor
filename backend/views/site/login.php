<?php

use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

Icon::map($this);

$this->title = 'Iniciar Sesión';

?>

<div class="site-login">
    <div class="col-sm-4 offset-sm-4">
        <div class="col-sm-12 text-center" style="margin-bottom: 10px;">
            <img src="logo_250x250.png">
        </div>
        <div class="col-sm-12">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="col-sm-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($usuario, 'usuarios_correo')->textInput() ?>
            <?= $form->field($usuario, 'usuarios_clave')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Icon::show('sign-in-alt').' Entrar', ['class' => 'btn btn-purpura btn-block', 'name' => 'login-button']) ?>
                <?= Html::a('Olvidé mi clave', ['olvido'], ['class' => 'btn btn-outline-purpura btn-block']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-sm-12">
            <?php
                if (isset($data))
                {
                    if ($data['error']) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?= Icon::show('times-circle').' '.$data['mensaje'] ?>
                        </div>
                    <?php }
                }
            ?>
        </div>
    </div>
</div>