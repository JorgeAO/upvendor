<?php

use yii\helpers\Html;

$this->title = 'Editar Vendedor: ' . $model->vendedor_id.' - '.$model->vendedor_nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Vendedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->vendedor_id, 'url' => ['view', 'vendedor_id' => $model->vendedor_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="vendedores-update">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>