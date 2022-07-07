<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TipoIdentificacionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-identificacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tipoiden_id') ?>

    <?= $form->field($model, 'tipoiden_descripcion') ?>

    <?= $form->field($model, 'fk_par_estados') ?>

    <?= $form->field($model, 'fc') ?>

    <?= $form->field($model, 'uc') ?>

    <?php // echo $form->field($model, 'fm') ?>

    <?php // echo $form->field($model, 'um') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
