<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProveedoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proveedores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'proveedor_id') ?>

    <?= $form->field($model, 'fk_par_tipo_persona') ?>

    <?= $form->field($model, 'fk_par_tipo_identificacion') ?>

    <?= $form->field($model, 'proveedor_identificacion') ?>

    <?= $form->field($model, 'proveedor_nombre') ?>

    <?php // echo $form->field($model, 'proveedor_apellido') ?>

    <?php // echo $form->field($model, 'proveedor_razonsocial') ?>

    <?php // echo $form->field($model, 'proveedor_celular') ?>

    <?php // echo $form->field($model, 'proveedor_correo') ?>

    <?php // echo $form->field($model, 'proveedor_ttodatos') ?>

    <?php // echo $form->field($model, 'proveedor_fttodatos') ?>

    <?php // echo $form->field($model, 'proveedor_fnacimiento') ?>

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
