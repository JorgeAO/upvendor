<?php
use app\models\Estados;
use app\models\TipoIdentificacion;
use app\models\TipoPersona;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

Icon::map($this);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="proveedores-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-3">
            <?php 
                echo $form->field($model, 'fk_par_tipo_persona')
                    ->dropDownList(
                        ArrayHelper::map(TipoPersona::find()->asArray()->all(), 'tipopers_id', 'tipopers_descripcion'),
                        [
                            'id' => 'fk_par_tipo_persona',
                            'onchange'=>'chgTipoPersona()',
                            'class'=>'form-control form-control-sm'
                        ]
                    );
            ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'fk_par_tipo_identificacion')
                ->dropDownList(ArrayHelper::map(TipoIdentificacion::find()->asArray()->all(), 'tipoiden_id', 'tipoiden_descripcion'),
                [ 'class'=>'form-control form-control-sm' ]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'proveedor_identificacion')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-4 natural">
            <?= $form->field($model, 'proveedor_primer_nombre')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-4 natural">
            <?= $form->field($model, 'proveedor_segundo_nombre')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-4 natural">
            <?= $form->field($model, 'proveedor_primer_apellido')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-4 natural">
            <?= $form->field($model, 'proveedor_segundo_apellido')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-12 juridico">
            <?= $form->field($model, 'proveedor_razonsocial')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'proveedor_celular')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'proveedor_correo')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'proveedor_direccion')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'proveedor_barrio')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-3 natural">
            <?= 
                $form->field($model, 'proveedor_fnacimiento')->widget(DatePicker::className(), [
                    'options' => [ 'class'=>'form-control form-control-sm' ],
                    'clientOptions' => [
                        'changeMonth'=>true,
                        'changeYear'=>true,
                    ],
                    'language' => 'es',
                    'dateFormat' => 'yyyy-MM-dd',
                ])
            ?>
        </div>
        <div class="col-sm-3">
            <label>Acepta Tratamiento de Datos</label><br>
            <?= $form->field($model,'proveedor_ttodatos')->checkBox(['label'=>'', $model->proveedor_ttodatos == '1' ? 'checked' : '']) ?>
        </div>
        <div class="col-sm-3">
            <?php 
            if (isset($model->proveedor_id))
                echo $form->field($model, 'fk_par_estados')->dropDownList(ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'), ['class'=>'form-control form-control-sm']);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php

        if (isset($data))
        {
            if ($data['error'] == false) {
                echo '<div class="alert alert-success" role="alert">';
                echo Icon::show('check-circle').' '.$data['mensaje'];
                echo '</div>';
            }
            if ($data['error'] == true) {
                echo '<div class="alert alert-danger" role="alert">';
                echo Icon::show('times-circle').' '.$data['mensaje'];
                echo '</div>';
            }
        }
    ?>

</div>

<script>
$(document).ready(function(){
    chgTipoPersona();
});

function chgTipoPersona() {
    var tipoPersona = $('#fk_par_tipo_persona')[0].value;

    // 1 - Persona natural
    if (tipoPersona == 1){
        $('.natural').prop('hidden',false);
        $('.juridico').prop('hidden',true);
    }
    else{
        $('.natural').prop('hidden',true);
        $('.juridico').prop('hidden',false);
    }
}
</script>