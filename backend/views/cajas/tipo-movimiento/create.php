<?php

use yii\helpers\Html;

$this->title = 'Agregar Tipo de Movimiento';
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Movimiento', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-movimiento-create">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>