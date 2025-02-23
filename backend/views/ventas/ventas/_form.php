<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Cliente;
use app\models\FormaPago;
use kartik\icons\Icon;
use yii\jui\AutoComplete;
use app\models\Vendedores;

Icon::map($this);
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="ventas-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-purpura">
                    Cliente
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <?php 
                            echo $form->field($model, 'fk_cli_cliente')->widget(\yii\jui\AutoComplete::class, [
                                'clientOptions' => [
                                    'source' => Cliente::find()->select(["concat(cliente_identificacion, ' - ', cliente_nombre_completo) as value"])->asArray()->all(),
                                ],
                                'options' => [
                                    'placeholder' => 'Escriba el nombre o identificación del cliente',
                                    'class' => 'form-control form-control-sm',
                                    'value' => isset($model->venta_id) ? Cliente::find()->where(['cliente_id'=>$model->fk_cli_cliente])->all()[0]->cliente_identificacion.' - '.Cliente::find()->where(['cliente_id'=>$model->fk_cli_cliente])->all()[0]->cliente_nombre_completo : '',
                                    'readonly' => isset($model->venta_id) ? true : false
                                ],
                            ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <?php 
                            echo $form->field($model, 'fk_ven_vendedor')->widget(\yii\jui\AutoComplete::class, [
                                'clientOptions' => [
                                    'source' => Vendedores::find()->select(["concat(vendedor_identificacion, ' - ', vendedor_nombre_completo) as value"])->asArray()->all(),
                                ],
                                'options' => [
                                    'placeholder' => 'Escriba el nombre o identificación del vendedor',
                                    'class' => 'form-control form-control-sm',
                                    'value' => isset($model->venta_id) ? Vendedores::find()->where(['vendedor_id'=>$model->fk_ven_vendedor])->all()[0]->vendedor_identificacion.' - '.Vendedores::find()->where(['vendedor_id'=>$model->fk_ven_vendedor])->all()[0]->vendedor_nombre_completo : '',
                                    'readonly' => isset($model->venta_id) ? true : false
                                ],
                            ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Observación</label>
                        <?= $form->field($model, 'venta_observacion')->textarea(['class' => 'form-control form-control-sm', 'placeholder' => 'Escriba la observación de la venta'])->label(false) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-purpura">
                    Datos de la Venta
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td><label>Fecha Venta</label></td>
                            <td><?= $form->field($model, 'venta_fecha_venta')->textInput([
                                'class' => 'form-control form-control-sm',
                                'readonly'=>true,
                                'value'=>Date('Y-m-d')
                            ])->label(false) ?></td>
                        </tr>
                        <tr>
                            <td><label>Forma de Pago</label></td>
                            <td><?= $form->field($model, 'fk_par_forma_pago')->dropDownList(
                                ArrayHelper::map(FormaPago::find()->asArray()->all(), 'formpago_id', 'formpago_descripcion'),
                                ['class' => 'form-control form-control-sm']
                            )->label(false) ?></td>
                        </tr>
                        <tr>
                            <td><label>Total</label></td>
                            <td><?= Html::input('text', 'venta_total', '', [
                                'id' => 'venta_total',
                                'class' => 'form-control form-control-sm',
                                'readonly' => true
                            ]) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2">
            <div class="card">
                <div class="card-header bg-purpura">
                    Productos
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped table-hover table-responsive-sm" id="tblProductos">
                        <thead>
                            <tr>
                                <th style="width: 45%;">Producto</th>
                                <th style="width: 10%;">Cantidad</th>
                                <th style="width: 10%;">Valor Unitario</th>
                                <th style="width: 10%;">Valor Total</th>
                                <th style="width: 10%;">% Descuento</th>
                                <th style="width: 10%;">Valor Final</th>
                                <th style="width: 5%;">Quitar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (isset($productos))
                                {
                                    foreach ($productos as $key => $value) 
                                    {
                                        echo '<script>
                                                setTimeout(()=>{ 
                                                    agregarFila('.$value['fk_pro_productos'].', '.$value['ventprod_cantidad'].', '.$value['ventprod_vlr_unitario'].', '.$value['ventprod_dcto'].'); 
                                                }, 1000);
                                            </script>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-azul btn-sm mt-2" onclick="agregarFila()">
                        <?= Icon::show('plus-circle') ?> Agregar Producto
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group mt-3">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
        <?php if ($model->isNewRecord): ?>
            <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
        <?php endif; ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script>
    var idFila = 0;

    function agregarFila(producto_id = 0, cantidad = 0, vlr_unit = 0, dcto = 0)
    {
        this.idFila = this.idFila+1;
        let fila = `<tr id="fila_`+idFila+`">
                <td><select class="form-control form-control-sm" name="productos[`+idFila+`][producto_`+idFila+`]" id="producto_`+idFila+`" onchange="obtenerPrecioVenta(`+idFila+`)"></select></td>
                <td><input type="number" class="form-control form-control-sm" name="productos[`+idFila+`][cantidad_`+idFila+`]" id="cantidad_`+idFila+`" onchange="calcularValorTotal(`+idFila+`); calcularTotalCompra();"></td>
                <td><input type="number" class="form-control form-control-sm" name="productos[`+idFila+`][vlr_unit_`+idFila+`]" id="vlr_unit_`+idFila+`" onchange="calcularValorTotal(`+idFila+`); calcularTotalCompra();"></td>
                <td><input type="number" class="form-control form-control-sm" name="productos[`+idFila+`][vlr_total_`+idFila+`]" id="vlr_total_`+idFila+`" readonly="true"></td>
                <td><input type="number" class="form-control form-control-sm" name="productos[`+idFila+`][dcto_`+idFila+`]" id="dcto_`+idFila+`" onchange="calcularDescuento(`+idFila+`); calcularTotalCompra();"></td>
                <td><input type="number" class="form-control form-control-sm vlr_final" name="productos[`+idFila+`][vlr_final_`+idFila+`]" id="vlr_final_`+idFila+`" readonly="true"></td>
                <td style="text-align: center;"><button type="button" class="btn btn-danger btn-sm" onclick="quitarFila(`+idFila+`)"><?= Icon::show('minus-circle') ?></button></td>
            </tr>`;
        
        $("#tblProductos tbody:last-child").before(fila);

        listarProductos(idFila, producto_id, cantidad, vlr_unit, dcto);
    }

    async function listarProductos(id_fila, producto_id, cantidad, vlr_unit, dcto)
    {
        await new Promise(resolve => {
            $.ajax({
                url: 'index.php?r=productos/listar',
                method: 'POST',
                dataType: 'JSON',
                data: { 
                    'fk_par_estados': '1',
                },
                success:function(data){
                    data.forEach(element => {
                        $('#producto_'+id_fila).append('<option value="'+element.producto_id+'">'+element.producto_descripcion+'</option>');
                    });

                    let vlr_total = cantidad * vlr_unit;

                    $('#producto_'+id_fila).val(producto_id);
                    $('#cantidad_'+id_fila).val(cantidad);
                    $('#vlr_unit_'+id_fila).val(vlr_unit);
                    $('#dcto_'+id_fila).val(dcto);
                    $('#vlr_final_'+id_fila).val(vlr_unit);
                    $("#vlr_total_"+id_fila).val(vlr_total);
                    $("#vlr_final_"+id_fila).val(vlr_total - (vlr_total * dcto / 100));

                    calcularTotalCompra();
                    
                    resolve();
                },
            });
        });
    }

    function quitarFila(fila)
    {
        $('#fila_'+fila).remove();
        calcularTotalCompra();
    }

    function calcularValorTotal(id_fila)
    {
        let cant = Number($("#cantidad_"+id_fila)[0].value == undefined ? 0 : $("#cantidad_"+id_fila)[0].value);
        let vlr_unit = Number($("#vlr_unit_"+id_fila)[0].value == undefined ? 0 : $("#vlr_unit_"+id_fila)[0].value);

        $("#vlr_total_"+id_fila).val(cant * vlr_unit);
        $("#vlr_final_"+id_fila).val(cant * vlr_unit);
        
    }

    function calcularDescuento(id_fila)
    {
        let dcto = Number($("#dcto_"+id_fila)[0].value == undefined ? 0 : $("#dcto_"+id_fila)[0].value);
        let vlr_total = Number($("#vlr_total_"+id_fila)[0].value);

        $("#vlr_final_"+id_fila).val(vlr_total - (vlr_total * dcto / 100));

    }

    function calcularTotalCompra()
    {
        let totalCompra = 0;
        $('.vlr_final').each(function(i, val){
            totalCompra += Number(val.value);
        });
        
        $('#venta_total').val(totalCompra);
    }

    async function obtenerPrecioVenta(id_fila)
    {
        await new Promise(resolve => {
            $.ajax({
                url: 'index.php?r=productos/obtener-precio-venta',
                method: 'POST',
                dataType: 'JSON',
                data: { 
                    'producto_id': $('#producto_'+id_fila).val(),
                },
                success:function(data){
                    let vlr_unit = data;
                    $('#vlr_unit_'+id_fila).val(vlr_unit);
                    calcularValorTotal(id_fila);
                    calcularDescuento(id_fila);
                    calcularTotalCompra();
                    resolve();
                },
            });
        });
    }


    

    async function listarProductos(id_fila, producto_id, cantidad, vlr_unit, dcto)
    {
        await new Promise(resolve => {
            $.ajax({
                url: 'index.php?r=productos/listar',
                method: 'POST',
                dataType: 'JSON',
                data: { 
                    'fk_par_estados': '1',
                },
                success:function(data){
                    data.forEach(element => {
                        $('#producto_'+id_fila).append('<option value="'+element.producto_id+'">'+element.producto_descripcion+'</option>');
                    });

                    let vlr_total = cantidad * vlr_unit;

                    $('#producto_'+id_fila).val(producto_id);
                    $('#cantidad_'+id_fila).val(cantidad);
                    $('#vlr_unit_'+id_fila).val(vlr_unit);
                    $('#dcto_'+id_fila).val(dcto);
                    $('#vlr_final_'+id_fila).val(vlr_unit);
                    $("#vlr_total_"+id_fila).val(vlr_total);
                    $("#vlr_final_"+id_fila).val(vlr_total - (vlr_total * dcto / 100));

                    calcularTotalCompra();
                    
                    resolve();
                },
            });
        });
    }
</script>