<?php

use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

Icon::map($this);

$this->title = 'Iniciar Sesión';

?>

<div class="site-login">
    <div class="row">
        <div class="col-sm-5 offset-sm-1">
            <div class="d-flex align-items-center" style="height: 100%;">
                <img src="logo_180x180.png">
            </div>
        </div>
        <div class="col-sm-5">
            <div class="text-center">
                <h4><?= Html::encode($this->title) ?></h4>
            </div>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($usuario, 'usuarios_correo')->textInput() ?>
            <?= $form->field($usuario, 'usuarios_clave')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton(Icon::show('sign-in-alt').' Entrar', ['class' => 'btn btn-personalizado btn-block', 'name' => 'login-button']) ?>
                <!--?= Html::a('Olvidé mi clave', ['olvido'], ['class' => 'btn btn-outline-purpura btn-block']) ?-->
            </div>
            <?php ActiveForm::end(); ?>
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