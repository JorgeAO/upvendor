<?php

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);

$this->title = 'Reestablecer Clave';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="">

    <h4><?= Html::encode($this->title) ?></h4>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'usuarios_correo')->textInput(['required' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'usuarios_token')->textInput(['required' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'usuarios_nuevaclave')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'usuarios_repnuevaclave')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
                <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
        if (isset($data))
        {
            if ($data['error']) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= Icon::show('times-circle').' '.$data['mensaje'] ?>
                </div>
            <?php }
        }
    ?>

</div>