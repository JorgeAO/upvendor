<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TipoMovimientoSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tipo-movimiento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tipomovi_id') ?>

    <?= $form->field($model, 'tipomovi_descripcion') ?>

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
