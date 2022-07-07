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
<div class="cliente-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <!--label>Tipo de Persona</label><br-->
            <?php 
                echo $form->field($model, 'fk_par_tipo_persona')
                    ->dropDownList(
                        ArrayHelper::map(TipoPersona::find()->asArray()->all(), 'tipopers_id', 'tipopers_descripcion'),
                        [
                            'id' => 'fk_par_tipo_persona',
                            'onchange'=>'chgTipoPersona()'
                        ]
                    );

                /*echo Html::dropDownList(
                    'fk_par_tipo_persona',
                    null, // Valor que estará seleccionado por defecto
                    ArrayHelper::map(TipoPersona::find()->asArray()->all(), 'tipopers_id', 'tipopers_descripcion'), 
                    [
                        'class'=>'form-control',
                        'onchange'=>'chgTipoPersona()'
                    ]
                );*/
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'fk_par_tipo_identificacion')->dropDownList(ArrayHelper::map(TipoIdentificacion::find()->asArray()->all(), 'tipoiden_id', 'tipoiden_descripcion')) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'cliente_identificacion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 natural">
            <?= $form->field($model, 'cliente_nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 natural">
            <?= $form->field($model, 'cliente_apellido')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 juridico">
            <?= $form->field($model, 'cliente_razonsocial')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'cliente_celular')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'cliente_correo')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6 natural">
            <?= 
                $form->field($model, 'cliente_fnacimiento')->widget(DatePicker::className(), [
                    'options' => [
                        'class' => 'form-control',
                    ],
                    'clientOptions' => [
                        'changeMonth'=>true,
                        'changeYear'=>true,
                    ],
                    'language' => 'es',
                    'dateFormat' => 'yyyy-MM-dd',
                ])
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'cliente_maxdiasmora')->textInput(['type'=>'number']) ?>
        </div>
        <div class="col-sm-6">
            <label>Acepta Tratamiento de Datos</label><br>
            <?= $form->field($model,'cliente_ttodatos')->checkBox(['label'=>'', $model->cliente_ttodatos == '1' ? 'checked' : '']) ?>
        </div>
        <div class="col-sm-6">
            <label>Acepta Publicidad por Correo Electrónico</label><br>
            <?= $form->field($model,'cliente_pubcorreo')->checkBox(['label'=>'', $model->cliente_pubcorreo == '1' ? 'checked' : '']) ?>
        </div>
        <div class="col-sm-6">
            <?php 
            if (isset($model->cliente_id))
                echo $form->field($model, 'fk_par_estados')->dropDownList(ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'));
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