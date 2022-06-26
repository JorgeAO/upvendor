<?php

use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);

$this->title = 'Recuperar Clave';

?>
<div>
    <h4><?= Html::encode($this->title) ?></h4>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'usuarios_correo')->textInput(['requiered' => true]) ?>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <?= Html::submitButton(Icon::show('key').' Recuperar clave', ['class' => 'btn btn-sm btn-azul']) ?>
                <?= Html::a(Icon::show('times').' Cancelar', ['login'], ['class' => 'btn btn-sm btn-danger']) ?>
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