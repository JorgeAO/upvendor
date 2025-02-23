<?php

use app\models\Perfiles;
use kartik\icons\Icon;
use yii\base\Controller;
use yii\console\Controller as ConsoleController;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\rest\Controller as RestController;
use yii\web\Controller as WebController;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

Icon::map($this);

$this->title = 'Permisos';
$this->params['breadcrumbs'][] = $this->title;

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="permisos-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <label>Perfil</label>
            <?= Html::dropDownList(
                "fk_par_perfiles", 
                null, 
                ArrayHelper::map(Perfiles::find()->asArray()->all(), 'perfiles_id', 'perfiles_descripcion'), 
                [ 
                    'class'=> "form-control form-control-sm",
                    'onchange'=>'consultarPermisos()',
                    'prompt'=>''
                ]
            ) ?>
            <br>
            <?= Html::button(Icon::show('save').' Guardar', [ 'class'=>'btn btn-sm btn-azul', 'id'=>'btn_guardar' ]) ?>
            <br>
            <div id="div_esperar"></div>

        </div>
        <div class="col-sm-8 col-md-8">
            <label>Permisos</label>
            <form id="frm_permisos">
            <div id="div_permisos">
                <table class="table table-sm table-bordered table-striped table-responsive-md">
                    <thead>
                        <tr>
                            <th scope="col">Código</th>
                            <th scope="col">Opción</th>
                            <th scope="col">Crear</th>
                            <th scope="col">Consultar</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Eliminar</th>
                            <th scope="col">Listar</th>
                            <th scope="col">Ver</th>
                            <th scope="col">En Menú</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_permisos"></tbody>
                </table>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
    	$('#btn_guardar').prop('disabled',true);

		$('#btn_guardar').on('click', function(){
			$('#div_esperar').html('<br><div class="alert alert-primary">Espere por favor</div>')
            
            $.ajax({
                url: "index.php?r=permisos/guardar-permisos",
                method: "POST",
                dataType: "JSON",
                data: {
                    perfil:document.getElementsByName('fk_par_perfiles')[0].value,
                    permisos: $('#frm_permisos').serializeArray()
                },
                success:function(data){
                    if (!data.error){
                        $('#div_esperar').html('<br><div class="alert alert-success">El proceso se realizó con éxito.<br>La pantalla se acualizará automaticamente en 5 segundos.</div>')
                        setTimeout( () => { location.reload(); }, 5000 );
                    } 
                    if (data.error) $('#div_esperar').html('<br><div class="alert alert-danger">'+data.mensaje+'</div>')
                },
            });
		});

	});

    function consultarPermisos() {
        var perfil = document.getElementsByName('fk_par_perfiles')[0].value;

        if (perfil == ""){
            $('#tbl_permisos').html('');
            $('#btn_guardar').prop('disabled',true);
            return;
        }
        
        $('#btn_guardar').prop('disabled',false);

        $.ajax({
            url: "index.php?r=permisos/consultar-permisos",
            method: "POST",
            dataType: "JSON",
            data: { perfil : perfil },
            success:function(data){
                $('#tbl_permisos').html('');
                var permisos = '';
                data.forEach(val => {
                    permisos += '<tr>'+
                        '<td>'+val.opciones_id+'</td>'+
                        '<td>'+val.opciones_nombre+'</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opciones_id+'_c" class="form-check-input chk_permiso" type="checkbox" '+(val.c == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opciones_id+'_r" class="form-check-input chk_permiso" type="checkbox" '+(val.r == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opciones_id+'_u" class="form-check-input chk_permiso" type="checkbox" '+(val.u == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opciones_id+'_d" class="form-check-input chk_permiso" type="checkbox" '+(val.d == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opciones_id+'_l" class="form-check-input chk_permiso" type="checkbox" '+(val.l == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opciones_id+'_v" class="form-check-input chk_permiso" type="checkbox" '+(val.v == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '<td>'+
                        '<div class="form-check">'+
                        '<input name="'+val.opciones_id+'_m" class="form-check-input chk_permiso" type="checkbox" '+(val.m == 1 ? 'checked' : '')+'>'+
                        '</div>'+
                        '</td>'+
                        '</tr>';
                });
                $('#tbl_permisos').append(permisos);
            },
        });
    }
</script>