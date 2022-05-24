<?php

use yii\helpers\Html;

$this->title = 'Editar Perfil: ' . $model->perfiles_id." - ".$model->perfiles_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->perfiles_id, 'url' => ['view', 'perfiles_id' => $model->perfiles_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="perfiles-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>