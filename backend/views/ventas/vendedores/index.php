<?php

use app\models\Vendedores;
use app\models\TipoIdentificacion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;

Icon::map($this);

$this->title = 'Vendedores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendedores-index">
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
                'label'=>'Tipo de Identificación',
                'value'=>function($data) {
                    return TipoIdentificacion::find()->where(['tipoiden_id'=>$data->fk_par_tipo_identificacion])->all()[0]->tipoiden_descripcion;
                },
                'attribute'=>'fk_par_tipo_identificacion',
                'filter'=>ArrayHelper::map(TipoIdentificacion::find()->asArray()->all(), 'tipoiden_id', 'tipoiden_descripcion'),
            ],
            'vendedor_identificacion',
            'vendedor_nombre_completo',
            'vendedor_correo_electronico',
            'vendedor_telefono',
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
                        Html::a(Icon::show('eye'), ['view', 'vendedor_id' => $data->vendedor_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        Html::a(Icon::show('pencil-alt'), ['update', 'vendedor_id' => $data->vendedor_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']).
                        '</div>';
                    return $strOpciones;
                },
            ],
        ],
    ]); ?>
</div>
