<?php

use app\models\Categoria;
use app\models\Estados;
use app\models\Marcas;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = $model->producto_id.' - '.$model->producto_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="productos-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'producto_id' => $model->producto_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'producto_id' => $model->producto_id], [
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
                    'producto_id',
                    'producto_nombre',
                    'producto_descripcion',
                    'producto_referencia',
                    [
                        'label' => 'Categoría',
                        'value' => function($data) {
                            return Categoria::find()->where(['categoria_id' => $data->fk_pro_categoria])->all()[0]->categoria_descripcion;
                        }
                    ],
                    [
                        'label' => 'Cantidad en Stock',
                        'format'=>'html',
                        'value' => function($data) {
                            if ($data['producto_stock'] == 0) {
                                return $data['producto_stock'] . ' <span class="badge badge-danger">Alerta! Stock en estado crítico</span>';
                            }
                            else if ($data['producto_stock'] < $data['producto_alertastock'] && $data['producto_stock'] > 0) {
                                return $data['producto_stock'] . ' <span class="badge badge-danger">Atención! El producto se está agotando</span>';
                            }
                            else if ($data['producto_stock'] == $data['producto_alertastock']) {
                                return $data['producto_stock'] . ' <span class="badge badge-warning">Atención! Últimas unidades</span>';
                            }
                            else {
                                return $data['producto_stock'];
                            }
                        },
                        'visible' => $model->fk_pro_categoria != 2,
                    ],
                    [
                        'label' => 'Alerta de Stock',
                        'value' => function($data) {
                            return $data->producto_alertastock;
                        },
                        'visible' => $model->fk_pro_categoria != 2,
                    ],
                    [
                        'label' => 'Precio de Compra',
                        'value' => function($data){
                            return Yii::$app->formatter->asCurrency($data->producto_preciocompra, '$');
                        },
                        'visible' => $model->fk_pro_categoria != 2,
                    ],
                    [
                        'label' => 'Precio de Venta',
                        'value' => function($data){
                            return Yii::$app->formatter->asCurrency($data->producto_precioventa, '$');
                        },
                    ],
                    [
                        'label'=>'Marca',
                        'value'=>function($data){
                            return Marcas::find()->where(['marca_id'=>$data->fk_pro_marcas])->all()[0]->marca_descripcion;
                        },
                        'visible' => $model->fk_pro_categoria != 2,
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
            <div class="card mb-2">
                <div class="card-header bg-purpura">
                    Atributos
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-striped table-hover">
                        <tr>
                            <th>Atributo</th>
                            <th>Valor</th>
                        </tr>
                        <?php
                            foreach ($atributos as $key => $value) {
                                echo '<tr>
                                        <td>'.$value['atributo_descripcion'].'</td>
                                        <td>'.$value['atrivalor_valor'].'</td>
                                    </tr>';
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div class="card mb-2" hidden>
                <div class="card-header bg-purpura">
                    Acciones Rápidas
                </div>
                <div class="card-body">
                    <?= Html::a(Icon::show('cart-arrow-down').' Comprar', ['valores', 'producto_id' => $model->producto_id], ['class' => 'btn btn-sm btn-azul']) ?>
                    <?= Html::a(Icon::show('shopping-bag').' Vender', ['valores', 'producto_id' => $model->producto_id], ['class' => 'btn btn-sm btn-azul']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
