<?php

use yii\helpers\Html;

$this->title = 'Editar Compra: ' . $model->compra_id;
$this->params['breadcrumbs'][] = ['label' => 'Compras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->compra_id, 'url' => ['view', 'compra_id' => $model->compra_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="compras-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'compraProductos' => $compraProductos,
    ]) ?>

</div>
