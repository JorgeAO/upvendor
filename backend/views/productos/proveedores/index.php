<?php
use app\models\Estados;
use app\models\TipoIdentificacion;
use app\models\TipoPersona;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

Icon::map($this);

$this->title = 'Proveedores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proveedores-index">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm'],
        'columns' => [
            'proveedor_id',
            [
                'label'=>'Tipo Persona',
                'value'=>function($data) {
                    return TipoPersona::find()->where(['tipopers_id'=>$data->fk_par_tipo_persona])->all()[0]->tipopers_descripcion;
                },
                'attribute'=>'fk_par_estados',
                'filter'=>ArrayHelper::map(TipoPersona::find()->asArray()->all(), 'tipopers_id', 'tipopers_descripcion'),
            ],
            [
                'label'=>'Tipo Identificación',
                'value'=>function($data) {
                    return TipoIdentificacion::find()->where(['tipoiden_id'=>$data->fk_par_tipo_persona])->all()[0]->tipoiden_descripcion;
                },
                'attribute'=>'fk_par_estados',
                'filter'=>ArrayHelper::map(TipoIdentificacion::find()->asArray()->all(), 'tipoiden_id', 'tipoiden_descripcion'),
            ],
            'proveedor_identificacion',
            'proveedor_nombrecompleto',
            'proveedor_celular',
            'proveedor_correo',
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
                        Html::a(Icon::show('eye'), ['view', 'proveedor_id' => $data->proveedor_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        Html::a(Icon::show('pencil-alt'), ['update', 'proveedor_id' => $data->proveedor_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']).
                        Html::a(Icon::show('trash'), ['delete', 'proveedor_id' => $data->proveedor_id], [
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
