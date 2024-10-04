<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MovimientosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="movimientos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'movimiento_id') ?>

    <?= $form->field($model, 'movimiento_fecha') ?>

    <?= $form->field($model, 'fk_caj_tipo_movimiento') ?>

    <?= $form->field($model, 'fk_caj_cajas') ?>

    <?= $form->field($model, 'movimiento_monto') ?>

    <?php // echo $form->field($model, 'fc') ?>

    <?php // echo $form->field($model, 'uc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
