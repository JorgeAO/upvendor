<?php
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);
?>
<div class="tipo-persona-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">   
        <div class="col-sm-6">
            <?= $form->field($model, 'tipopers_descripcion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?php 
                if (isset($model->tipopers_id))
                    echo $form->field($model, 'fk_par_estados')->dropDownList(ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'));
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>