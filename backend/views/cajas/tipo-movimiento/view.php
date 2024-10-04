<?php
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = $model->tipomovi_id.' - '.$model->tipomovi_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Movimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipo-movimiento-view">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show('pencil-alt').' Editar', ['update', 'tipomovi_id' => $model->tipomovi_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('trash').' Eliminar', ['delete', 'tipomovi_id' => $model->tipomovi_id], [
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
            'tipomovi_id',
            'tipomovi_descripcion',
            [
                'attribute' => 'fk_par_estados',
                'value' => function ($data) {
                    return Estados::find()->where(['estados_id'=>$data->fk_par_estados])->all()[0]->estados_descripcion;
                },
            ],
            [
                'attribute' => 'tipomovi_operacion',
                'value' => function ($data) {
                    return $data->tipomovi_operacion == '+' ? 'SUMA' : 'RESTA';
                },
            ],
            'fc',
            'uc',
            'fm',
            'um',
        ],
    ]) ?>

</div>
