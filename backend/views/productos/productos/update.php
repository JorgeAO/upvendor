<?php

use yii\helpers\Html;

$this->title = 'Editar Producto: ' . $model->producto_id." - ".$model->producto_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Producto', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->producto_id, 'url' => ['view', 'producto_id' => $model->producto_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="productos-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'atributos' => $atributos,
    ]) ?>

</div>
