<?php

use yii\helpers\Html;

$this->title = 'Editar Tipo de Persona: ' . $model->tipopers_id." - ".$model->tipopers_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Persona', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tipopers_id, 'url' => ['view', 'tipopers_id' => $model->tipopers_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="tipo-persona-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
