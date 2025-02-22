<?php

use app\models\Caja;
use app\models\FormaPago;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;

Icon::map($this);

$this->title = 'Formas de Pago';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forma-pago-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm'],
        'columns' => [
            'formpago_id',
            'formpago_descripcion',
            [
                'label'=>'Caja',
                'value'=>function($data) {
                    $caja = Caja::find()->where(['caja_id' => $data->fk_caj_cajas])->one();
                    return $caja ? $caja->caja_descripcion : 'NO HAY CAJA ASIGNADA';
                },
                'attribute'=>'fk_caj_cajas',
                'filter'=>ArrayHelper::map(Caja::find()->asArray()->all(), 'caja_id', 'caja_descripcion'),
            ],
            [
                'label'=>'Estado',
                'value'=>function($data) {
                    return Estados::find()->where(['estados_id'=>$data->fk_par_estados])->all()[0]->estados_descripcion;
                },
                'attribute'=>'fk_par_estados',
                'filter'=>ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'),
            ],
            [
                'label'=>'Opciones',
                'format'=>'raw',
                'value'=> function($data) {
                    $strOpciones = '';
                    $strOpciones = 
                        '<div class="btn-group" role="group" aria-label="Basic example">'.
                        Html::a(Icon::show('eye'), ['view', 'formpago_id' => $data->formpago_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        Html::a(Icon::show('pencil-alt'), ['update', 'formpago_id' => $data->formpago_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']).
                        Html::a(Icon::show('trash'), ['delete', 'formpago_id' => $data->formpago_id], [
                            'class' => 'btn btn-sm btn-danger',
                            'title'=>'Eliminar',
                            'data' => [
                                'confirm' => '¿Está seguro que desea eliminar el registro?',
                                'method' => 'post',
                            ],
                        ]).
                        '</div>'
                        ;

                    return $strOpciones;
                }
            ]
        ],
    ]); ?>


</div>
