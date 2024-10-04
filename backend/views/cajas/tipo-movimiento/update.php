<?php

use yii\helpers\Html;

$this->title = 'Editar Tipo de Movimiento: ' . $model->tipomovi_id.' - '.$model->tipomovi_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Movimiento', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tipomovi_id, 'url' => ['view', 'tipomovi_id' => $model->tipomovi_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipo-movimiento-update">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>