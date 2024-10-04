<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\VendedoresSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="vendedores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'vendedor_id') ?>

    <?= $form->field($model, 'fk_par_tipo_identificacion') ?>

    <?= $form->field($model, 'vendedor_identificacion') ?>

    <?= $form->field($model, 'vendedor_nombre_completo') ?>

    <?= $form->field($model, 'vendedor_correo_electronico') ?>

    <?php // echo $form->field($model, 'vendedor_telefono') ?>

    <?php // echo $form->field($model, 'vendedor_direccion') ?>

    <?php // echo $form->field($model, 'fk_seg_usuarios') ?>

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
