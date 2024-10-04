<?php

use yii\helpers\Html;

$this->title = 'Editar Caja: ' . $model->caja_id.' - '.$model->caja_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Cajas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->caja_id, 'url' => ['view', 'caja_id' => $model->caja_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="caja-update">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>