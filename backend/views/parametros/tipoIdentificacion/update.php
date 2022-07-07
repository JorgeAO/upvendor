<?php

use yii\helpers\Html;

$this->title = 'Editar Tipo de Identificación: ' . $model->tipoiden_id." - ".$model->tipoiden_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Identificación', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tipoiden_id, 'url' => ['view', 'tipoiden_id' => $model->tipoiden_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="tipo-identificacion-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
