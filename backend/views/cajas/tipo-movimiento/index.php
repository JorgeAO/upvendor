<?php

use app\models\TipoMovimiento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;

Icon::map($this);

$this->title = 'Tipo de Movimiento';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-movimiento-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm'],
        'columns' => [
            'tipomovi_id',
            'tipomovi_descripcion',
            [
                'label'=>'Operación',
                'value'=>function($data) {
                    return $data->tipomovi_operacion == '+' ? 'SUMA' : 'RESTA';
                },
                'attribute'=>'tipomovi_operacion',
                'filter'=>['+' => 'SUMA', '-' => 'RESTA'],
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
                    $strOpciones = 
                        '<div class="btn-group" role="group" aria-label="Basic example">'.
                        Html::a(Icon::show('eye'), ['view', 'tipomovi_id' => $data->tipomovi_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        Html::a(Icon::show('pencil-alt'), ['update', 'tipomovi_id' => $data->tipomovi_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']).
                        Html::a(Icon::show('trash'), ['delete', 'tipomovi_id' => $data->tipomovi_id], [
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
            ],
        ],
    ]); ?>
</div>