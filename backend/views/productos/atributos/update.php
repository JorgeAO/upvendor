<?php

use yii\helpers\Html;

$this->title = 'Editar Atributo: ' . $model->atributo_id." - ".$model->atributo_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Atributo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->atributo_id, 'url' => ['view', 'atributo_id' => $model->atributo_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="atributos-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
