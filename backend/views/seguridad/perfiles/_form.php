<?php

use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);

?>

<div class="perfiles-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'perfiles_descripcion')->textInput(['maxlength' => true]) ?>
    
    <?php 
        if (isset($model->perfiles_id))
            echo $form->field($model, 'fk_par_estados')->dropDownList(ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'));
    ?>

    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>