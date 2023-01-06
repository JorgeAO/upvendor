<?php

use app\models\Atributos;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$atributo = Atributos::findOne($model->fk_pro_atributos);

$this->title = $model->atrivalor_id.' - '.$model->atrivalor_valor;
$this->params['breadcrumbs'][] = ['label' => 'Atributos', 'url' => ['atributos/index']];
$this->params['breadcrumbs'][] = ['label' => 'Valores del Atributo: '.$atributo->atributo_descripcion, 'url' => ['index', 'atributo_id'=>$model->fk_pro_atributos]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="atributos-valor-view">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index','atributo_id'=>$model->fk_pro_atributos], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create','atributo_id'=>$model->fk_pro_atributos], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'atrivalor_id' => $model->atrivalor_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'atrivalor_id' => $model->atrivalor_id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-striped table-hover table-sm'],
        'attributes' => [
            'atrivalor_id',
            'atrivalor_valor',
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
