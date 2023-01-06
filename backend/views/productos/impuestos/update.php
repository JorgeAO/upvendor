<?php

use yii\helpers\Html;

$this->title = 'Editar Impuesto: ' . $model->impuesto_id." - ".$model->impuesto_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Impuesto', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->impuesto_id, 'url' => ['view', 'impuesto_id' => $model->impuesto_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="impuestos-update">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
