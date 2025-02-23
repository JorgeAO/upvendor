<?php

use app\models\Cliente;
use app\models\EstadosVenta;
use app\models\Vendedores;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = 'Venta #'.$model->venta_id;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ventas-view">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?php if ($model->fk_ven_estado_venta == 1): ?>
            <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'venta_id' => $model->venta_id], ['class' => 'btn btn-sm btn-azul']) ?>
            <?= Html::a(Icon::show("times").' Anular', ['delete', 'venta_id' => $model->venta_id], [
                'class' => 'btn btn-sm btn-danger',
                'data' => [
                    'confirm' => '¿Está seguro que desea anular la compra?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>
    <div class="row">
        <div class="col-sm-4">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-hover table-sm'],
                'attributes' => [
                    'venta_id',
                    [
                        'label'=>'Cliente',
                        'value'=>function($data){
                            return Cliente::find()->where(['cliente_id'=>$data->fk_cli_cliente])->all()[0]->cliente_nombre_completo;
                        }
                    ],
                    [
                        'label'=>'Vendedor',
                        'value'=>function($data){
                            $vendedor = Vendedores::find()->where(['vendedor_id'=>$data->fk_ven_vendedor])->all();
                            return count($vendedor) > 0 ? $vendedor[0]->vendedor_nombre_completo : 'NO ENCONTRADO';
                        }
                    ],
                    'venta_fecha_venta',
                    [
                        'label'=>'Estado',
                        'value'=>function($data){
                            return EstadosVenta::find()->where(['ventesta_codigo'=>$data->fk_ven_estado_venta])->all()[0]->ventesta_descripcion;
                        }
                    ],
                    'venta_observacion',
                    'fc',
                    'uc',
                    'fm',
                    'um',
                ],
            ]) ?>

            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-purpura">
                        Productos
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered table-striped table-hover table-responsive-md">
                            <tr>
                                <th style="width: 40%;">Producto</th>
                                <th style="width: 12%;">Cantidad</th>
                                <th style="width: 12%;">Valor Unitario</th>
                                <th style="width: 12%;">Valor Total</th>
                                <th style="width: 12%;">% Descuento</th>
                                <th style="width: 12%;">Valor Final</th>
                            </tr>
                            <?php
                                foreach ($productos as $key => $value) {
                                    echo '<tr>
                                            <td>'.$value['producto_descripcion'].'</td>
                                            <td class="text-right">'.$value['ventprod_cantidad'].'</td>
                                            <td class="text-right">'.Yii::$app->formatter->asCurrency($value['ventprod_vlr_unitario'], '$').'</td>
                                            <td class="text-right">'.Yii::$app->formatter->asCurrency($value['ventprod_vlr_total'], '$').'</td>
                                            <td class="text-right">'.$value['ventprod_dcto'].'</td>
                                            <td class="text-right">'.Yii::$app->formatter->asCurrency($value['ventprod_vlr_final'], '$').'</td>
                                        </tr>';
                                }
                            ?>
                        </table>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header bg-purpura">
                        Acciones Rápidas
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>