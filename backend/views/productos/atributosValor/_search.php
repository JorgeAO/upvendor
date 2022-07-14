<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AtributosValorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="atributos-valor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'atrivalor_id') ?>

    <?= $form->field($model, 'fk_pro_atributos') ?>

    <?= $form->field($model, 'atrivalor_valor') ?>

    <?= $form->field($model, 'fk_par_estados') ?>

    <?= $form->field($model, 'fc') ?>

    <?php // echo $form->field($model, 'uc') ?>

    <?php // echo $form->field($model, 'fm') ?>

    <?php // echo $form->field($model, 'um') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
