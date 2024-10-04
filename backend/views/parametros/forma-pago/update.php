<?php

use yii\helpers\Html;

$this->title = 'Editar Forma de Pago: ' . $model->formpago_id." - ".$model->formpago_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Forma de Pago', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->formpago_id, 'url' => ['view', 'formpago_id' => $model->formpago_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="forma-pago-update">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>