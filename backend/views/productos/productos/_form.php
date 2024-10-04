<?php

use app\models\Categoria;
use app\models\Estados;
use app\models\Impuestos;
use app\models\Marcas;
use kartik\icons\Icon;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Icon::map($this);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="productos-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-purpura">
                    Información General
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'producto_nombre')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $form->field($model, 'fk_pro_marcas')->dropDownList(ArrayHelper::map(Marcas::find()->asArray()->all(), 'marca_id', 'marca_descripcion'), ['class'=>'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $form->field($model, 'producto_referencia')->textInput(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $form->field($model, 'fk_pro_categoria')->dropDownList(ArrayHelper::map(Categoria::find()->asArray()->all(), 'categoria_id', 'categoria_descripcion'), ['class'=>'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-sm-12">
                            <?= $form->field($model, 'producto_descripcion')->textArea(['maxlength' => true, 'class'=>'form-control form-control-sm']) ?>
                        </div>
                        <?php 
                            if (isset($model->producto_id))
                                echo '<div class="col-sm-12">'.$form->field($model, 'fk_par_estados')->dropDownList(ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'), ['class'=>'form-control form-control-sm']).'</div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-purpura">
                    Cantidad
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'producto_stock')->textInput(['class'=>'form-control form-control-sm']) ?>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Alerta de Bajo Stock</label>
                            <?= $form->field($model, 'producto_alertastock')->textInput(['class'=>'form-control form-control-sm'])->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header bg-purpura">
                    Precio e Impuestos
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tbody>
                            <tr>
                                <th>Precio de compra</th>
                                <td><?= $form->field($model, 'producto_preciocompra')->textInput(['class'=>'form-control form-control-sm'])->label(false) ?></td>
                            </tr>
                            <tr>
                                <th>Precio de venta</th>
                                <td><?= $form->field($model, 'producto_precioventa')->textInput(['class'=>'form-control form-control-sm'])->label(false) ?></td>
                            </tr>
                            <tr>
                                <th>Impuesto</th>
                                <td><?= $form->field($model, 'producto_porc_imp')->dropDownList(
                                    ArrayHelper::map(Impuestos::find()->asArray()->all(), 'impuesto_id', function($impuesto) {
                                        return $impuesto['impuesto_descripcion'] . ' (' . $impuesto['impuesto_porcentaje'] . '%)';
                                    }),
                                    ['class'=>'form-control form-control-sm', 'onchange' => 'calcularImpuesto()']
                                )->label(false) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2" hidden>
            <div class="card">
                <div class="card-header bg-purpura">
                    Características
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered table-sm table-striped table-hover" id="tblAtributos">
                            <thead>
                                <tr>
                                    <th scope="col">Atributo</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Quitar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($atributos))
                                    {
                                        foreach ($atributos as $key => $value)
                                        {
                                            echo '<script>
                                                setTimeout(() => {
                                                    agregarFila('.$value['fk_pro_atributos'].', '.$value['fk_pro_atributos_valor'].');
                                                }, 1000); 
                                            </script>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-azul btn-sm mt-2" onclick="agregarFila()">
                            <?= Icon::show('plus-circle') ?> Agregar Atributo
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2">
            <div class="form-group">
                <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
                <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var idAtributo = 0;

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    function agregarFila(id_atributo = 0, id_atributo_valor = 0)
    {
        this.idAtributo = this.idAtributo+1;
        let fila = `<tr id="atr_`+idAtributo+`">
                <td><select class="form-control form-control-sm" name="atributos[`+idAtributo+`][atributo_`+idAtributo+`]" id="atributo_`+idAtributo+`" onchange="cargarValores(`+idAtributo+`)"></select></td>
                <td><select class="form-control form-control-sm" name="atributos[`+idAtributo+`][atrivalor_`+idAtributo+`]" id="atrivalor_`+idAtributo+`"></select></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="quitarFila(`+idAtributo+`)"><?= Icon::show('minus-circle') ?></button>
                </td>
            </tr>`;

        $("#tblAtributos tbody:last-child").before(fila);

        cargarAtributos(idAtributo, id_atributo, id_atributo_valor);
    }

    function quitarFila(fila)
    {
        $('#atr_'+fila).remove();
    }

    async function cargarAtributos(fila, id_atributo, id_atributo_valor)
    {
        await new Promise(resolve => {
            $.ajax({
                url: 'index.php?r=atributos/listar',
                method: 'POST',
                dataType: 'JSON',
                data: { 'fk_par_estados': '1' },
                success:function(data){
                    data.forEach(element => {
                        $('#atributo_'+fila).append('<option value="'+element.atributo_id+'">'+element.atributo_descripcion+'</option>');
                    });

                    $('#atributo_'+fila).val(id_atributo);

                    cargarValores(fila, id_atributo_valor);
                }
            });
            resolve();
        });
    }

    async function cargarValores(fila, id_atributo_valor)
    {
        await new Promise(resolve => {
            $.ajax({
                url: 'index.php?r=atributos-valor/listar',
                method: 'POST',
                dataType: 'JSON',
                data: { 
                    'fk_pro_atributos': $('#atributo_'+fila)[0].value,
                    'fk_par_estados': '1'
                },
                success:function(data){
                    $('#atrivalor_'+fila).empty();
                    data.forEach(element => {
                        $('#atrivalor_'+fila).append('<option value="'+element.atrivalor_id+'">'+element.atrivalor_valor+'</option>');
                    });
                    $('#atrivalor_'+fila).val(id_atributo_valor);
                },
            });
            resolve();
        });
    }

    function cargarFilas(atributos)
    {
        console.info(atributos);
    }

    function calcularImpuesto() {
        let valorSinImp = $('#productos-producto_precioventa').val() == '' ? 0 : $('#productos-producto_precioventa').val();
        let porcImpuesto = 0;
        let valorConImp = 0;

        $.ajax({
            url: 'index.php?r=impuestos/calcular',
            method: 'POST',
            dataType: 'JSON',
            data: { 
                'impuesto_id': $('#productos-producto_porc_imp').val()
            },
            success:function(data){
                porcImpuesto = data;
            },
        });

        valorConImp = valorSinImp + (valorSinImp * porcImpuesto / 100);

        //console.info(valorConImp);
    }
</script>