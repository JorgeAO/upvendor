<?php

use app\models\Estados;
use app\models\Perfiles;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'usuarios_nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usuarios_apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usuarios_telefono')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usuarios_correo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usuarios_clave')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'fk_seg_perfiles')->dropDownList(ArrayHelper::map(Perfiles::find()->asArray()->all(), 'perfiles_id', 'perfiles_descripcion')) ?>
    
    <?php 
        if (isset($model->usuarios_id))
            echo $form->field($model, 'fk_par_estados')->dropDownList(ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'));
    ?>

    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>