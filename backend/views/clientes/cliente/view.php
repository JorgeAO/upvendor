<?php
use app\models\Estados;
use app\models\TipoIdentificacion;
use app\models\TipoPersona;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = $model->cliente_id.' - '.$model->cliente_nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Cliente', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="cliente-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'cliente_id' => $model->cliente_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'cliente_id' => $model->cliente_id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-hover table-sm'],
                'attributes' => [
                    'cliente_id',
                    [
                        'label'=>'Tipo de Persona',
                        'value'=>function($data){
                            return TipoPersona::find()->where(['tipopers_id'=>$data->fk_par_tipo_persona])->all()[0]->tipopers_descripcion;
                        }
                    ],
                    [
                        'label'=>'Tipo de Identificación',
                        'value'=>function($data){
                            return TipoIdentificacion::find()->where(['tipoiden_id'=>$data->fk_par_tipo_identificacion])->all()[0]->tipoiden_descripcion;
                        }
                    ],
                    'cliente_identificacion',
                    [
                        'label'=>'Primer Nombre',
                        'value'=>$model->cliente_primer_nombre,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    [
                        'label'=>'Segundo Nombre',
                        'value'=>$model->cliente_segundo_nombre,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    [
                        'label'=>'Primer Apellido',
                        'value'=>$model->cliente_primer_apellido,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    [
                        'label'=>'Segundo Apellido',
                        'value'=>$model->cliente_segundo_apellido,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    [
                        'label'=>'Razón Social',
                        'value'=>$model->cliente_razonsocial,
                        'visible'=> $model->fk_par_tipo_persona == 2 ? '1' : '0',
                    ],
                    'cliente_nombre_completo',
                    [
                        'label'=>'Fecha de Nacimiento',
                        'value'=>$model->cliente_fnacimiento ? date('Y-m-d', strtotime($model->cliente_fnacimiento . ' +5 hours')) : null,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    'cliente_celular',
                    'cliente_correo',
                    'cliente_direccion',
                    'cliente_barrio',
                    'cliente_maxdiasmora',
                    [
                        'label'=>'Acepta Tto. de Datos',
                        'value'=>$model->cliente_ttodatos == 1 ? 'Si' : 'No',
                    ],
                    'cliente_fttodatos',
                    [
                        'label'=>'Acepta Publicidad por Correo',
                        'value'=>$model->cliente_pubcorreo == 1 ? 'Si' : 'No',
                    ],
                    [
                        'label'=>'Estado',
                        'value'=>function($data){
                            return Estados::find()->where(['estados_id'=>$data->fk_par_estados])->all()[0]->estados_descripcion;
                        }
                    ],
                    'fc',
                    'uc',
                    'fm',
                    'um',
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-purpura">
                    Últimas 5 Compras
                </div>
                <div class="card-body">
                    [tabla]
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-purpura">
                    Top 5 Productos Favoritos
                </div>
                <div class="card-body">
                    [tabla]
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-purpura">
                    Acciones Rápidas
                </div>
                <div class="card-body">
                    <?= Html::a(Icon::show('shopping-bag').' Nueva Venta', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
                    <?= Html::a(Icon::show('chart-line').' Ver Compras', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
                </div>
            </div>
        </div>
    </div>

</div>
