<?php
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = $model->atributo_id.' - '.$model->atributo_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Atributo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
?>
<div class="atributos-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'atributo_id' => $model->atributo_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'atributo_id' => $model->atributo_id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-hover table-sm'],
                'attributes' => [
                    'atributo_id',
                    'atributo_descripcion',
                    [
                        'label'=>'Estado',
                        'value'=>function($data){
                            return Estados::find()->where(['estados_id'=>$data->fk_par_estados])->all()[0]->estados_descripcion;
                        }
                    ],
                    'fc',
                    'uc',
                    'fm',
                    'um',
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header bg-purpura">
                    Acciones Rápidas
                </div>
                <div class="card-body">
                    <?= Html::a(Icon::show('list').' Ver Valores', ['valores', 'atributo_id' => $model->atributo_id], ['class' => 'btn btn-sm btn-azul']) ?>
                </div>
            </div>
        </div>
    </div>


</div>
