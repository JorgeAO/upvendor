<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClienteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cliente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cliente_id') ?>

    <?= $form->field($model, 'fk_par_tipo_persona') ?>

    <?= $form->field($model, 'fk_par_tipo_identificacion') ?>

    <?= $form->field($model, 'cliente_identificacion') ?>

    <?= $form->field($model, 'cliente_nombre') ?>

    <?php // echo $form->field($model, 'cliente_apellido') ?>

    <?php // echo $form->field($model, 'cliente_razonsocial') ?>

    <?php // echo $form->field($model, 'cliente_celular') ?>

    <?php // echo $form->field($model, 'cliente_correo') ?>

    <?php // echo $form->field($model, 'cliente_maxdiasmora') ?>

    <?php // echo $form->field($model, 'cliente_ttodatos') ?>

    <?php // echo $form->field($model, 'cliente_fttodatos') ?>

    <?php // echo $form->field($model, 'cliente_fnacimiento') ?>

    <?php // echo $form->field($model, 'cliente_pubcorreo') ?>

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
