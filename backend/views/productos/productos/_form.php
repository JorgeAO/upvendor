<?php
use app\models\Estados;
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

    <div id="accordion">
        <div class="card">
            <div class="card-header bg-purpura encabezado-acordeon" id="headingInfoGral" data-toggle="collapse" data-target="#infoGral" aria-expanded="true" aria-controls="infoGral">
                Información General
            </div>
            <div id="infoGral" class="collapse show" aria-labelledby="headingInfoGral" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($model, 'producto_nombre')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'fk_pro_marcas')->dropDownList(ArrayHelper::map(Marcas::find()->asArray()->all(), 'marca_id', 'marca_descripcion')) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'producto_referencia')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'producto_descripcion')->textArea(['maxlength' => true]) ?>
                        </div>
                        <?php 
                            if (isset($model->producto_id))
                                echo '<div class="col-sm-6">'.$form->field($model, 'fk_par_estados')->dropDownList(ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion')).'</div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-purpura encabezado-acordeon" id="headingCaracteristicas" data-toggle="collapse" data-target="#caracteristicas" aria-expanded="true" aria-controls="caracteristicas">
                Características
            </div>
            <div id="caracteristicas" class="collapse" aria-labelledby="headingCaracteristicas" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <button type="button" class="btn btn-azul btn-sm" onclick="agregarFila()">
                            <?= Icon::show('plus-circle') ?> Agregar Atributo
                        </button>
                        <table class="table table-bordered table-sm table-striped table-hover mt-3" id="tblAtributos">
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
                                                setTimeout( ()=> { agregarFila(); }, 400 );
                                                setTimeout( ()=> { $("#atributo_'.($key+1).'").val('.$value['fk_pro_atributos'].'); cargarValores('.($key+1).'); }, 800 );
                                                setTimeout( ()=> {  $("#atrivalor_'.($key+1).'").val('.$value['fk_pro_atributos_valor'].'); }, 1200 );
                                            </script>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-purpura encabezado-acordeon" id="headingCantidad" data-toggle="collapse" data-target="#cantidad" aria-expanded="true" aria-controls="cantidad">
                Cantidad
            </div>
            <div id="cantidad" class="collapse" aria-labelledby="headingCantidad" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'producto_stock')->textInput() ?>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Alerta de Bajo Stock</label>
                            <?= $form->field($model, 'producto_alertastock')->textInput()->label(false) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-purpura encabezado-acordeon" id="headingPrecio" data-toggle="collapse" data-target="#precio" aria-expanded="true" aria-controls="precio">
                Precio
            </div>
            <div id="precio" class="collapse" aria-labelledby="headingPrecio" data-parent="#accordion">
                <div class="card-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'producto_preciocompra')->textInput() ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'producto_precioventa')->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="form-group">
        <?= Html::submitButton(Icon::show('save').' Guardar', ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('times').' Cancelar', ['index'], ['class' => 'btn btn-sm btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var idAtributo = 0;

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    function agregarFila()
    {
        this.idAtributo = this.idAtributo+1;
        console.info(this.idAtributo);
        let fila = `<tr id="atr_`+idAtributo+`">
                <th><select class="form-control form-control-sm" name="atributos[`+idAtributo+`][atributo_`+idAtributo+`]" id="atributo_`+idAtributo+`" onchange="cargarValores(`+idAtributo+`)"></select></th>
                <td><select class="form-control form-control-sm" name="atributos[`+idAtributo+`][atrivalor_`+idAtributo+`]" id="atrivalor_`+idAtributo+`"></select></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="quitarFila(`+idAtributo+`)"><?= Icon::show('minus-circle') ?></button>
                </td>
            </tr>`;

        $("#tblAtributos tbody:last-child").before(fila);

        cargarAtributos(idAtributo);
    }

    function quitarFila(fila)
    {
        $('#atr_'+fila).remove();
    }

    function cargarAtributos(id_atributo)
    {
        $.ajax({
            url: 'index.php?r=atributos/listar',
            method: 'POST',
            dataType: 'JSON',
            data: { 'fk_par_estados': '1' },
            success:function(data){
                data.forEach(element => {
                    $('#atributo_'+id_atributo).append('<option value="'+element.atributo_id+'">'+element.atributo_descripcion+'</option>');
                });
                cargarValores(id_atributo);
            },
        });
    }

    function cargarValores(id_atributo)
    {
        $.ajax({
            url: 'index.php?r=atributos-valor/listar',
            method: 'POST',
            dataType: 'JSON',
            data: { 
                'fk_pro_atributos': $('#atributo_'+id_atributo)[0].value,
                'fk_par_estados': '1'
            },
            success:function(data){
                $('#atrivalor_'+id_atributo).empty();
                data.forEach(element => {
                    $('#atrivalor_'+id_atributo).append('<option value="'+element.atrivalor_id+'">'+element.atrivalor_valor+'</option>');
                });
            },
        });
    }

    function cargarFilas(atributos)
    {
        console.info(atributos);
    }
</script>