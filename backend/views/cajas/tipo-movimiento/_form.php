<?php
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);
?>

<div class="tipo-movimiento-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'tipomovi_descripcion')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm' ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'tipomovi_operacion')->dropDownList(['+' => 'SUMA', '-' => 'RESTA'], ['class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-md-6">
            <?php   
                if (isset($model->tipomovi_id))
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
