<?php

use app\models\Movimientos;
use app\models\TipoMovimiento;
use app\models\Caja;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;

Icon::map($this);

$this->title = 'Movimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movimientos-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm table-responsive-md'],
        'columns' => [
            [
                'attribute' => 'movimiento_id',
                'label' => 'Código',
                'contentOptions' => ['style' => 'width:2%; white-space:nowrap;'],
            ],
            'movimiento_observacion',
            'movimiento_fecha',
            [
                'label'=>'Tipo de Movimiento',
                'value'=>function($data) {
                    return TipoMovimiento::find()->where(['tipomovi_id'=>$data->fk_caj_tipo_movimiento])->all()[0]->tipomovi_descripcion;
                },
                'attribute'=>'fk_caj_tipo_movimiento',
                'filter'=>ArrayHelper::map(TipoMovimiento::find()->asArray()->all(), 'tipomovi_id', 'tipomovi_descripcion'),
            ],
            [
                'label'=>'Caja',
                'value'=>function($data) {
                    $caja = Caja::find()->where(['caja_id'=>$data->fk_caj_cajas])->all();
                    if (count($caja) == 0) {
                        return 'NO ASIGNADA';
                    }
                    return Caja::find()->where(['caja_id'=>$data->fk_caj_cajas])->all()[0]->caja_descripcion;
                },
                'attribute'=>'fk_caj_cajas',
                'filter'=>ArrayHelper::map(Caja::find()->asArray()->all(), 'caja_id', 'caja_descripcion'),
            ],
            [
                'label'=>'Monto',
                'value'=>function($data) {
                    return Yii::$app->formatter->asCurrency($data->movimiento_monto, '$');
                }
            ],
            [
                'label'=>'Opciones',
                'format'=>'raw',
                'value'=> function($data) {
                    $strOpciones = 
                        '<div class="btn-group" role="group" aria-label="Basic example">'.
                        Html::a(Icon::show('eye'), ['view', 'movimiento_id' => $data->movimiento_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        '</div>'
                        ;

                    return $strOpciones;
                }
            ],
        ],
    ]); ?>


</div>
