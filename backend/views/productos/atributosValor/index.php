<?php
use app\models\Atributos;
use app\models\AtributosValor;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

Icon::map($this);

$atributo = Atributos::findOne($atributo_id);

$this->title = 'Valores del Atributo: '.$atributo->atributo_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Atributos', 'url' => ['atributos/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atributos-valor-index">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['/atributos/index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['atributos-valor/create', 'atributo_id' => $atributo->atributo_id], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-hover table-sm table-responsive-md'],
        'columns' => [
            'atrivalor_id',
            /*[
                'label'=>'Atributo',
                'value'=>function($data) {
                    return Atributos::find()->where(['atributo_id'=>$data->fk_pro_atributos])->all()[0]->atributo_descripcion;
                },
                'attribute'=>'fk_pro_atributos',
                'filter'=>ArrayHelper::map(Atributos::find()->asArray()->all(), 'atributo_id', 'atributo_descripcion'),
                'filterInputOptions'=>[
                    'class'=>'form-control',
                    'disabled'=>true
                ]
            ],*/
            'atrivalor_valor',
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
                        Html::a(Icon::show('eye'), ['atributos-valor/view', 'atrivalor_id' => $data->atrivalor_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Ver Detalles']).
                        Html::a(Icon::show('pencil-alt'), ['atributos-valor/update', 'atrivalor_id' => $data->atrivalor_id], ['class' => 'btn btn-sm btn-azul', 'title'=>'Editar']).
                        Html::a(Icon::show('trash'), ['atributos-valor/delete', 'atrivalor_id' => $data->atrivalor_id], [
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
