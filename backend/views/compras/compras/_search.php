<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ComprasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="compras-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'compra_id') ?>

    <?= $form->field($model, 'fk_pro_proveedores') ?>

    <?= $form->field($model, 'compra_fecha_compra') ?>

    <?= $form->field($model, 'compra_fecha_confirmacion') ?>

    <?= $form->field($model, 'compra_fecha_cierre') ?>

    <?php // echo $form->field($model, 'compra_fecha_anulacion') ?>

    <?php // echo $form->field($model, 'fk_com_estados_compra') ?>

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
