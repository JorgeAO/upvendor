<?php
use app\models\EstadosCompra;
use app\models\Proveedores;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = 'Compra #'.$model->compra_id;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="compras-view">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?php if ($model->fk_com_estados_compra == 1): ?>
            <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'compra_id' => $model->compra_id], ['class' => 'btn btn-sm btn-azul']) ?>
            <?= Html::a(Icon::show("times").' Anular', ['delete', 'compra_id' => $model->compra_id], [
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
                    'compra_id',
                    [
                        'label'=>'Proveedor',
                        'value'=>function($data){
                            return Proveedores::find()->where(['proveedor_id'=>$data->fk_pro_proveedores])->all()[0]->proveedor_nombrecompleto;
                        }
                    ],
                    'compra_fecha_compra',
                    [
                        'label'=>'Estado',
                        'value'=>function($data){
                            return EstadosCompra::find()->where(['compesta_id'=>$data->fk_com_estados_compra])->all()[0]->compesta_descripcion;
                        }
                    ],
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
                    <table class="table table-sm table-bordered table-striped table-hover">
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
                                        <td class="text-right">'.$value['comprod_cantidad'].'</td>
                                        <td class="text-right">'.Yii::$app->formatter->asCurrency($value['comprod_vlr_unitario'], '$').'</td>
                                        <td class="text-right">'.Yii::$app->formatter->asCurrency($value['comprod_vlr_total'], '$').'</td>
                                        <td class="text-right">'.$value['comprod_dcto'].'</td>
                                        <td class="text-right">'.Yii::$app->formatter->asCurrency($value['comprod_vlr_final'], '$').'</td>
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
                    <?= Html::a(Icon::show('paper-plane').' Enviar al Proveedor', ['enviar-compra', 'compra_id' => $model->compra_id], ['class' => 'btn btn-sm btn-azul']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
