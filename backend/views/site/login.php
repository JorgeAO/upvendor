<?php

use kartik\icons\Icon;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

Icon::map($this);

$this->title = 'Iniciar Sesión';

?>

<div class="site-login">
    <div class="mt-5 offset-lg-3 col-lg-6">
        <h1><?= Yii::$app->name ?></h1>
        <h4><?= Html::encode($this->title) ?></h4>

        <p>Por favor ingrese sus datos para iniciar sesión</p>
        
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($usuario, 'usuarios_correo')->textInput(['autofocus' => true]) ?>

            <?= $form->field($usuario, 'usuarios_clave')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Icon::show('sign-in-alt').' Entrar', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
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
