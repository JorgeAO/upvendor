<?php

use app\models\Estados;
use app\models\Perfiles;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

Icon::map($this);

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm'],
        'columns' => [
            'usuarios_id',
            'usuarios_nombre',
            'usuarios_apellido',
            'usuarios_telefono',
            'usuarios_correo',
            [
                'label'=>'Perfil',
                'value'=>function($data) {
                    return Perfiles::find()->where(['perfiles_id'=>$data->fk_seg_perfiles])->all()[0]->perfiles_descripcion;
                },
                'attribute'=>'fk_seg_perfiles',
                'filter'=>ArrayHelper::map(Perfiles::find()->asArray()->all(), 'perfiles_id', 'perfiles_descripcion'),
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
                        Html::a(Icon::show('eye'), ['view', 'usuarios_id' => $data->usuarios_id], ['class' => 'btn btn-sm btn-primary', 'title'=>'Ver Detalles']).
                        Html::a(Icon::show('pencil-alt'), ['update', 'usuarios_id' => $data->usuarios_id], ['class' => 'btn btn-sm btn-primary', 'title'=>'Editar']).
                        Html::a(Icon::show('trash'), ['delete', 'usuarios_id' => $data->usuarios_id], [
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