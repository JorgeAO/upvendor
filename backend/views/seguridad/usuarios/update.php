<?php

use yii\helpers\Html;

$this->title = 'Editar Usuario: '.$model->usuarios_id.' - '.$model->usuarios_nombre.' '.$model->usuarios_apellido;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->usuarios_id, 'url' => ['view', 'usuarios_id' => $model->usuarios_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuarios-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>