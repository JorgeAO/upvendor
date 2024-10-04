<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Movimientos $model */

$this->title = 'Update Movimientos: ' . $model->movimiento_id;
$this->params['breadcrumbs'][] = ['label' => 'Movimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->movimiento_id, 'url' => ['view', 'movimiento_id' => $model->movimiento_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="movimientos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
