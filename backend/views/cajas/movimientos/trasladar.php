<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Caja;

Icon::map($this);

$this->title = 'Trasladar Fondos';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="movimientos-trasladar">
    <h4><?= Html::encode($this->title) ?></h4>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row mb-3">
        <div class="col-sm-4">
            <label>Caja Origen</label>
            <?= Html::dropDownList(
                "caja_origen", 
                isset($model->caja_origen) ? $model->caja_origen : null,
                ArrayHelper::map(Caja::find()->asArray()->all(), 'caja_id', 'caja_descripcion'), 
                [ 
                    'class'=> "form-control form-control-sm",
                    'onchange' => 'validarCajas()',
                ]
            ) ?>
        </div>
        <div class="col-sm-4">
            <label>Caja Destino</label>
            <?= Html::dropDownList(
                "caja_destino", 
                isset($model->caja_destino) ? $model->caja_destino : null, 
                ArrayHelper::map(Caja::find()->asArray()->all(), 'caja_id', 'caja_descripcion'), 
                [ 
                    'class'=> "form-control form-control-sm",
                    'onchange' => 'validarCajas()',
                    'prompt' => '-- Seleccione una caja destino --',
                ]
            ) ?> 
        </div>
        <div class="col-sm-4">
            <label>Monto</label>
            <?= Html::textInput(
                "monto", 
                null, 
                [ 
                    'class'=> "form-control form-control-sm",
                ]
            ) ?> 
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-4">
            <label>Observación</label>
            <?= Html::textInput(
                "observacion", 
                null, 
                [ 
                    'class'=> "form-control form-control-sm",
                ]
            ) ?> 
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <?php if (isset($data['error']) && $data['error']): ?>
        <div class="alert alert-danger">
            <?= $data['mensaje'] ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function validarCajas() {
        var cajaOrigen = document.getElementsByName('caja_origen')[0].value;
        var cajaDestino = document.getElementsByName('caja_destino')[0].value;
        if (cajaOrigen === cajaDestino) {
            alert('La caja de origen no puede ser la misma que la caja de destino');
            document.getElementsByName('caja_destino')[0].value = '';
        }
    }
</script>