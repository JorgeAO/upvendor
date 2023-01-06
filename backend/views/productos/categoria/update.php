<?php

use yii\helpers\Html;

$this->title = 'Editar Categoría: ' . $model->categoria_id." - ".$model->categoria_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Categoría', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->categoria_id, 'url' => ['view', 'categoria_id' => $model->categoria_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="categoria-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
