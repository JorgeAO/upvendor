<?php

use app\models\Cliente;
use app\models\EstadosVenta;
use app\models\Ventas;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

Icon::map($this);

$this->title = 'Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ventas-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm'],
        'columns' => [
            'venta_id',
            [
                'label'=>'Cliente',
                'value'=>function($data) {
                    return Cliente::find()->where(['cliente_id'=>$data->fk_cli_cliente])->all()[0]->cliente_nombre_completo;
                },
                'attribute'=>'fk_cli_cliente',
                'filter'=>ArrayHelper::map(Cliente::find()->asArray()->all(), 'cliente_id', 'cliente_nombre_completo'),
            ],
            'venta_fecha_venta',
            [
                'label'=>'Estado',
                'format'=>'html',
                'value'=>function($data) {
                    $estado = EstadosVenta::find()->where(['ventesta_codigo'=>$data->fk_ven_estado_venta])->all()[0]->ventesta_descripcion;
                    $color = '';

                    switch ($data->fk_ven_estado_venta)
                    {
                        case '1':
                            $color = 'success';
                            break;
                        case '2':
                            $color = 'danger';
                            break;
                        default:
                            break;
                    }
                    
                    return '<span class="badge badge-'.$color.'">'.$estado.'</span>';
                },
                'attribute'=>'fk_ven_estado_venta',
                'filter'=>ArrayHelper::map(EstadosVenta::find()->asArray()->all(), 'ventesta_codigo', 'ventesta_descripcion'),
            ],
            [
                'label'=>'Opciones',
                'format'=>'raw',
                'value'=> function($data) {
                    $strOpciones = '';
                    $strOpciones = 
                        '<div class="btn-group" role="group" aria-label="Basic example">'.
                        Html::a(Icon::show('eye'), ['view', 'venta_id' => $data->venta_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        ($data->fk_ven_estado_venta == 1 ? Html::a(Icon::show('pencil-alt'), ['update', 'venta_id' => $data->venta_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']) : '').
                        '</div>'
                        ;

                    return $strOpciones;
                }
            ]
        ],
    ]); ?>


</div>
