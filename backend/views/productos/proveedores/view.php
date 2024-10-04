<?php
use app\models\Estados;
use app\models\EstadosCompra;
use app\models\TipoIdentificacion;
use app\models\TipoPersona;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = $model->proveedor_id.' - '.($model->fk_par_tipo_persona == 1 ? $model->proveedor_nombre.' '.$model->proveedor_apellido : $model->proveedor_razonsocial);
$this->params['breadcrumbs'][] = ['label' => 'Proveedor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="proveedores-view mb-3">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'proveedor_id' => $model->proveedor_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'proveedor_id' => $model->proveedor_id], [
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
                    'proveedor_id',
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
                    'proveedor_identificacion',
                    [
                        'label'=>'Nombre',
                        'value'=>$model->proveedor_primer_nombre,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    [
                        'label'=>'Segundo Nombre',
                        'value'=>$model->proveedor_segundo_nombre,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    [
                        'label'=>'Primer Apellido',
                        'value'=>$model->proveedor_primer_apellido,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    [
                        'label'=>'Segundo Apellido',
                        'value'=>$model->proveedor_segundo_apellido,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    [
                        'label'=>'Razón Social',
                        'value'=>$model->proveedor_razonsocial,
                        'visible'=> $model->fk_par_tipo_persona == 2 ? '1' : '0',
                    ],
                    [
                        'label'=>'Nombre Completo',
                        'value'=>$model->proveedor_nombrecompleto,
                    ],
                    [
                        'label'=>'Fecha de Nacimiento',
                        'value'=>$model->proveedor_fnacimiento ? date('Y-m-d', strtotime($model->proveedor_fnacimiento . ' +5 hours')) : null,
                        'visible'=> $model->fk_par_tipo_persona == 1 ? '1' : '0',
                    ],
                    'proveedor_celular',
                    'proveedor_correo',
                    'proveedor_direccion',
                    'proveedor_barrio',
                    [
                        'label'=>'Acepta Tto. de Datos',
                        'value'=>$model->proveedor_ttodatos == 1 ? 'Si' : 'No',
                    ],
                    'proveedor_fttodatos',
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
                <?php if (!empty($ultimasCompras)): ?>
                    <table class="table table-sm table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Compra</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ultimasCompras as $compra): ?>
                                <tr>
                                    <td><?= $compra->compra_id ?></td>
                                    <td><?= Yii::$app->formatter->asDate($compra->compra_fecha_compra, 'php:Y-m-d') ?></td>
                                    <td><?= 
                                        EstadosCompra::findOne($compra->fk_com_estados_compra)->compesta_descripcion == 'Anulada' ?
                                            '<span class="badge badge-danger">Anulada</span>' :
                                            '<span class="badge badge-success">'.EstadosCompra::findOne($compra->fk_com_estados_compra)->compesta_descripcion.'</span>'
                                    ?></td>
                                    <td>
                                        <?= Html::a(Icon::show('eye'), ['compras/view', 'compra_id' => $compra->compra_id], ['class' => 'btn btn-sm btn-azul', 'title' => 'Ver detalle']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay compras recientes para este proveedor.</p>
                <?php endif; ?>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-purpura">
                    Acciones Rápidas
                </div>
                <div class="card-body">
                    <?= Html::a(Icon::show('cart-arrow-down').' Nueva Compra', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
                    <?= Html::a(Icon::show('chart-line').' Ver Compras', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
