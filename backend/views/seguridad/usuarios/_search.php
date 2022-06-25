<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'usuarios_id') ?>

    <?= $form->field($model, 'usuarios_nombre') ?>

    <?= $form->field($model, 'usuarios_apellido') ?>

    <?= $form->field($model, 'usuarios_telefono') ?>

    <?= $form->field($model, 'usuarios_correo') ?>

    <?php // echo $form->field($model, 'usuarios_clave') ?>

    <?php // echo $form->field($model, 'usuarios_token') ?>

    <?php // echo $form->field($model, 'usuarios_vto_token') ?>

    <?php // echo $form->field($model, 'fk_seg_perfiles') ?>

    <?php // echo $form->field($model, 'fk_par_estados') ?>

    <?php // echo $form->field($model, 'fc') ?>

    <?php // echo $form->field($model, 'uc') ?>

    <?php // echo $form->field($model, 'fm') ?>

    <?php // echo $form->field($model, 'um') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>