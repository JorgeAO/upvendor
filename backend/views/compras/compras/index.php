<?php
use app\models\EstadosCompra;
use app\models\Proveedores;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

Icon::map($this);

$this->title = 'Compras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="compras-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm table-responsive-md'],
        'columns' => [
            'compra_id',
            [
                'label'=>'Proveedores',
                'value'=>function($data) {
                    return Proveedores::find()->where(['proveedor_id'=>$data->fk_pro_proveedores])->all()[0]->proveedor_nombrecompleto;
                },
                'attribute'=>'fk_pro_proveedores',
                'filter'=>ArrayHelper::map(Proveedores::find()->asArray()->all(), 'proveedor_id', 'proveedor_nombrecompleto'),
            ],
            'compra_fecha_compra',
            [
                'label'=>'Estado',
                'format'=>'html',
                'value'=>function($data){
                    $estado = EstadosCompra::find()->where(['compesta_id'=>$data->fk_com_estados_compra])->all()[0]->compesta_descripcion;
                    $color = '';

                    switch ($data->fk_com_estados_compra)
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
                'attribute'=>'fk_pro_proveedores',
                'filter'=>ArrayHelper::map(EstadosCompra::find()->asArray()->all(), 'compesta_id', 'compesta_descripcion'),
            ],
            [
                'label'=>'Opciones',
                'format'=>'raw',
                'value'=> function($data) {
                    $strOpciones = '';
                    $strOpciones = 
                        '<div class="btn-group" role="group" aria-label="Basic example">'.
                        Html::a(Icon::show('eye'), ['view', 'compra_id' => $data->compra_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        ($data->fk_com_estados_compra == 1 ? Html::a(Icon::show('pencil-alt'), ['update', 'compra_id' => $data->compra_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']) : '').
                        '</div>'
                        ;

                    return $strOpciones;
                }
            ]
        ],
    ]); ?>


</div>
