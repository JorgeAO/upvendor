<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'producto_id') ?>

    <?= $form->field($model, 'producto_nombre') ?>

    <?= $form->field($model, 'producto_descripcion') ?>

    <?= $form->field($model, 'producto_referencia') ?>

    <?= $form->field($model, 'producto_stock') ?>

    <?php // echo $form->field($model, 'producto_alertastock') ?>

    <?php // echo $form->field($model, 'producto_preciocompra') ?>

    <?php // echo $form->field($model, 'producto_precioventa') ?>

    <?php // echo $form->field($model, 'fk_pro_marcas') ?>

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
