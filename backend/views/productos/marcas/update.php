<?php

use yii\helpers\Html;

$this->title = 'Editar Marca: ' . $model->marca_id." - ".$model->marca_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Marca', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->marca_id, 'url' => ['view', 'marca_id' => $model->marca_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="marcas-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
