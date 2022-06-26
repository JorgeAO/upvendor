<?php

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);

$this->title = 'Reestablecer Clave';
?>
<div class="">

    <h4><?= Html::encode($this->title) ?></h4>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="form-group col-sm-12">
            <label>Correo Electrónico</label>
            <?= Html::input('text','usuarios_correo','', $options=['class'=>'form-control','required'=>true]) ?>
        </div>
        <div class="form-group col-sm-12">
            <label>Código de Seguridad</label>
            <?= Html::input('password','usuarios_token','', $options=['class'=>'form-control','required'=>true]) ?>
        </div>
        <div class="form-group col-sm-12">
            <label>Nueva Clave</label>
            <?= Html::input('password','usuarios_nuevaclave','', $options=['class'=>'form-control','required'=>true]) ?>
        </div>
        <div class="form-group col-sm-12">
            <label>Repita la Nueva Clave</label>
            <?= Html::input('password','usuarios_repnuevaclave','', $options=['class'=>'form-control','required'=>true]) ?>
        </div>
        <div class="form-group col-sm-12">
            <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
            <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
        if (isset($data))
        {
            if ($data['error'] == 'false') {
                echo '<div class="alert alert-success" role="alert">';
                echo Icon::show('check-circle').' '.$data['mensaje'];
                echo '</div>';
            }
            if ($data['error'] == 'true') {
                echo '<div class="alert alert-danger" role="alert">';
                echo Icon::show('times-circle').' '.$data['mensaje'];
                echo '</div>';
            }
        }
    ?>

</div>