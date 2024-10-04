<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\TipoMovimiento;
use app\models\Caja;
use kartik\icons\Icon;

Icon::map($this);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="movimientos-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-4">
            <?= 
                $form->field($model, 'movimiento_fecha')->widget(DatePicker::className(), [
                    'options' => [
                        'class' => 'form-control form-control-sm',
                        'readonly' => true
                    ],
                    'clientOptions' => [
                        'changeMonth'=>true,
                        'changeYear'=>true,
                        'language' => 'es',
                    ],
                    'dateFormat' => 'php:Y-m-d',
                ])
            ?>
        </div>
        <div class="col-sm-4">
            <?= 
                $form->field($model, 'fk_caj_tipo_movimiento')
                    ->dropDownList(
                        ArrayHelper::map(TipoMovimiento::find()->asArray()->all(), 'tipomovi_id', 'tipomovi_descripcion'),
                        [
                            'class' => 'form-control form-control-sm',
                            'id' => 'fk_caj_tipo_movimiento',
                        ]
                    );
            ?>
        </div>
        <div class="col-sm-4">
            <?= 
                $form->field($model, 'fk_caj_cajas')
                    ->dropDownList(
                        ArrayHelper::map(Caja::find()->asArray()->all(), 'caja_id', 'caja_descripcion'),
                        [
                            'class' => 'form-control form-control-sm',
                            'id' => 'fk_caj_cajas',
                        ]
                    );
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'movimiento_monto')->textInput(['class' => 'form-control form-control-sm']) ?>
        </div>
        <div class="col-sm-12">
            <?= 
                $form->field($model, 'movimiento_observacion')->textarea(['class' => 'form-control form-control-sm'])
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>