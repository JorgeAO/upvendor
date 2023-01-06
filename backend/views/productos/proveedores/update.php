<?php

use yii\helpers\Html;

$this->title = 'Editar Proveedor: '.$model->proveedor_id.' - '.($model->fk_par_tipo_persona == 1 ? $model->proveedor_nombre.' '.$model->proveedor_apellido : $model->proveedor_razonsocial);
$this->params['breadcrumbs'][] = ['label' => 'Proveedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->proveedor_id, 'url' => ['view', 'proveedor_id' => $model->proveedor_id]];
$this->params['breadcrumbs'][] = 'Editar';

\yii\web\YiiAsset::register($this);
?>
<div class="proveedores-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
