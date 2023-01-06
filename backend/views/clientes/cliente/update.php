<?php

use yii\helpers\Html;

$this->title = 'Editar Cliente: '.$model->cliente_id.' - '.($model->fk_par_tipo_persona == 1 ? $model->cliente_nombre.' '.$model->cliente_apellido : $model->cliente_razonsocial);
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cliente_id, 'url' => ['view', 'cliente_id' => $model->cliente_id]];
$this->params['breadcrumbs'][] = 'Editar';

\yii\web\YiiAsset::register($this);
?>
<div class="cliente-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
