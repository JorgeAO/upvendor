<?php

use app\models\Caja;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);
?>

<div class="forma-pago-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'formpago_descripcion')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm' ]) ?>
        </div>
        <div class="col-sm-6">
            <?php 
                echo $form->field($model, 'fk_caj_cajas')->dropDownList(
                    ArrayHelper::map(Caja::find()->asArray()->all(), 'caja_id', 'caja_descripcion'), 
                    ['class' => 'form-control form-control-sm']
                );
            ?>
        </div>
        <div class="col-sm-6">
            <?php 
                if (isset($model->formpago_id))
                    echo $form->field($model, 'fk_par_estados')->dropDownList(
                    ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'), 
                    ['class' => 'form-control form-control-sm']
                );
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>