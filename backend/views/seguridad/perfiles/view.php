<?php

use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = $model->perfiles_id.' - '.$model->perfiles_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);

?>

<div class="perfiles-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'perfiles_id' => $model->perfiles_id], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'perfiles_id' => $model->perfiles_id], [
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
            'perfiles_id',
            'perfiles_descripcion',
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