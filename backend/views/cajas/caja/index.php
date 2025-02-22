<?php

use app\models\Caja;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;

Icon::map($this);

$this->title = 'Cajas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="caja-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>
    <div class="alert alert-info">

        <h5>Total: <?= Yii::$app->formatter->asCurrency((float)$totalEnCaja, 'USD') ?></h5>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm'],
        'columns' => [
            'caja_id',
            'caja_descripcion',
            [
                'label'=>'Monto',
                'value'=>function($data) {
                    return Yii::$app->formatter->asCurrency($data->caja_monto, 'USD');
                },
            ],
            [
                'label'=>'Estado',
                'value'=>function($data) {
                    return Estados::find()->where(['estados_id'=>$data->fk_par_estado])->all()[0]->estados_descripcion;
                },
                'attribute'=>'fk_par_estado',
                'filter'=>ArrayHelper::map(Estados::find()->asArray()->all(), 'estados_id', 'estados_descripcion'),
            ],
            [
                'label'=>'Opciones',
                'format'=>'raw',
                'value'=> function($data) {
                    $strOpciones = '';
                    $strOpciones = 
                        '<div class="btn-group" role="group" aria-label="Basic example">'.
                        Html::a(Icon::show('eye'), ['view', 'caja_id' => $data->caja_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        Html::a(Icon::show('pencil-alt'), ['update', 'caja_id' => $data->caja_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']).
                        ($data->caja_monto == 0 ? 
                            Html::a(Icon::show('trash'), ['delete', 'caja_id' => $data->caja_id], [
                                'class' => 'btn btn-sm btn-danger',
                                'title'=>'Eliminar',
                                'data' => [
                                    'confirm' => '¿Está seguro que desea eliminar el registro?',
                                    'method' => 'post',
                                ],
                            ]) : 
                            ''
                        ).
                        '</div>'
                        ;

                    return $strOpciones;
                }
            ],
        ],
    ]); ?>


</div>
