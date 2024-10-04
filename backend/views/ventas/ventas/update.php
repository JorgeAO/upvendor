<?php

use yii\helpers\Html;

$this->title = 'Editar Venta: ' . $model->venta_id;
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->venta_id, 'url' => ['view', 'venta_id' => $model->venta_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ventas-update">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
        'productos' => $productos,
    ]) ?>

</div>
