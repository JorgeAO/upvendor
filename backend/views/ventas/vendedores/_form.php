<?php

use app\models\TipoIdentificacion;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);

?>

<div class="vendedores-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-4">
            <?php 
                echo $form->field($model, 'fk_par_tipo_identificacion')->dropDownList(
                    ArrayHelper::map(TipoIdentificacion::find()->asArray()->all(), 'tipoiden_id', 'tipoiden_descripcion'), 
                    ['class' => 'form-control form-control-sm']
                );
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'vendedor_identificacion')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'vendedor_nombre_completo')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'vendedor_correo_electronico')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'vendedor_telefono')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'vendedor_direccion')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
        </div>
        <?php if ($model->fk_seg_usuarios == null) { ?>
            <div class="col-sm-4">
                <label>¿Crear usuario para este vendedor?</label><br>
                <?= $form->field($model,'crear_usuario')->checkBox(['label'=>'', $model->crear_usuario == '1' ? 'checked' : '']) ?>
            </div>
        <?php } ?>
        <div class="col-sm-4">
            <?php 
                if (isset($model->vendedor_id))
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