<?php
use app\models\Estados;
use app\models\Proveedores;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

Icon::map($this);
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="compras-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-purpura">
                    Proveedor
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <?php 
                            echo $form->field($model, 'fk_pro_proveedores')->widget(\yii\jui\AutoComplete::class, [
                                'clientOptions' => [
                                    'source' => Proveedores::find()->select(["concat(proveedor_identificacion, ' - ', proveedor_nombrecompleto) as value"])->asArray()->all(),
                                ],
                                'options' => [
                                    'class' => 'form-control form-control-sm',
                                    'value' => isset($model->compra_id) ? Proveedores::find()->where(['proveedor_id'=>$model->fk_pro_proveedores])->all()[0]->proveedor_identificacion.' - '.Proveedores::find()->where(['proveedor_id'=>$model->fk_pro_proveedores])->all()[0]->proveedor_nombrecompleto : '',
                                    'readonly' => isset($model->compra_id) ? true : false
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-purpura">
                    Datos de la Compra
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <?= $form->field($model, 'compra_fecha_compra')
                            ->textInput([
                                'class' => 'form-control form-control-sm',
                                'readonly'=>true,
                                'value'=>Date('Y-m-d')
                            ]) 
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                            echo '<label>Total</label>';
                            echo Html::input('text', 'compra_total', '', [
                                'id' => 'compra_total',
                                'class' => 'form-control form-control-sm',
                                'readonly' => true
                            ])
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mt-2">
            <div class="card">
                <div class="card-header bg-purpura">
                    Agregar Producto
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped table-hover" id="tblProductos">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Valor Unitario</th>
                                <th>Valor Total</th>
                                <th>% Descuento</th>
                                <th>Valor Final</th>
                                <th>Quitar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (isset($compraProductos))
                                {
                                    foreach ($compraProductos as $key => $value) 
                                    {
                                        echo '<script>setTimeout( ()=>{ agregarFila(); } );</script>';
                                        echo '<script>
                                            setTimeout( 
                                                ()=>{
                                                    $("#producto_'.($key+1).'").val('.$value['fk_pro_productos'].');
                                                    $("#cantidad_'.($key+1).'").val('.$value['comprod_cantidad'].');
                                                    $("#vlr_unit_'.($key+1).'").val('.$value['comprod_vlr_unitario'].');
                                                    $("#dcto_'.($key+1).'").val('.$value['comprod_dcto'].');
                                                }, 400 
                                            );
                                            setTimeout(()=>{ calcularValorTotal('.($key+1).'); }, 800);
                                        </script>';
                                        echo '<script></script>';
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
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script>
    var idFila = 0;

    function agregarFila()
    {
        this.idFila = this.idFila+1;
        let fila = `<tr id="fila_`+idFila+`">
                <td><select class="form-control form-control-sm" name="productos[`+idFila+`][producto_`+idFila+`]" id="producto_`+idFila+`"></select></td>
                <td><input type="number" class="form-control form-control-sm" name="productos[`+idFila+`][cantidad_`+idFila+`]" id="cantidad_`+idFila+`" onchange="calcularValorTotal(`+idFila+`)"></td>
                <td><input type="number" class="form-control form-control-sm" name="productos[`+idFila+`][vlr_unit_`+idFila+`]" id="vlr_unit_`+idFila+`" onchange="calcularValorTotal(`+idFila+`)"></td>
                <td><input type="number" class="form-control form-control-sm" name="productos[`+idFila+`][vlr_total_`+idFila+`]" id="vlr_total_`+idFila+`" readonly="true"></td>
                <td><input type="number" class="form-control form-control-sm" name="productos[`+idFila+`][dcto_`+idFila+`]" id="dcto_`+idFila+`" onchange="calcularDescuento(`+idFila+`)"></td>
                <td><input type="number" class="form-control form-control-sm vlr_final" name="productos[`+idFila+`][vlr_final_`+idFila+`]" id="vlr_final_`+idFila+`" readonly="true"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="quitarFila(`+idFila+`)"><?= Icon::show('minus-circle') ?></button></td>
            </tr>`;
        
        $("#tblProductos tbody:last-child").before(fila);

        listarProductos(idFila);
    }

    function listarProductos(id_fila)
    {
        $.ajax({
            url: 'index.php?r=productos/listar',
            method: 'POST',
            dataType: 'JSON',
            data: { 
                '>producto_stock':'0',
                'fk_par_estados': '1',
            },
            success:function(data){
                data.forEach(element => {
                    $('#producto_'+id_fila).append('<option value="'+element.producto_id+'">'+element.producto_nombre+'</option>');
                });
            },
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
        
        calcularDescuento(id_fila);
    }

    function calcularDescuento(id_fila)
    {
        let dcto = Number($("#dcto_"+id_fila)[0].value == undefined ? 0 : $("#dcto_"+id_fila)[0].value);
        let vlr_total = Number($("#vlr_total_"+id_fila)[0].value);

        $("#vlr_final_"+id_fila).val(vlr_total - (vlr_total * dcto / 100));

        calcularTotalCompra();
    }

    function calcularTotalCompra()
    {
        let totalCompra = 0;
        $('.vlr_final').each(function(i, val){
            totalCompra += Number(val.value);
        });
        
        $('#compra_total').val(totalCompra);
    }
</script>