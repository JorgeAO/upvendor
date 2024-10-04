<?php
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);
?>

<div class="caja-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-8">
            <?= $form->field($model, 'caja_descripcion')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm' ]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'caja_monto')->textInput(['class' => 'form-control form-control-sm' ]) ?>
        </div>
    </div>
    <?php 
        if (isset($model->caja_id))
            echo $form->field($model, 'fk_par_estado')->dropDownList(
                ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'), 
                ['class' => 'form-control form-control-sm']
            );
    ?>
    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>