<?php
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

Icon::map($this);

$this->title = 'Tipos de Identificación';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-identificacion-index">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm table-responsive-md'],
        'columns' => [
            'tipoiden_id',
            'tipoiden_descripcion',
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
                        Html::a(Icon::show('eye'), ['view', 'tipoiden_id' => $data->tipoiden_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        Html::a(Icon::show('pencil-alt'), ['update', 'tipoiden_id' => $data->tipoiden_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']).
                        Html::a(Icon::show('trash'), ['delete', 'tipoiden_id' => $data->tipoiden_id], [
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
