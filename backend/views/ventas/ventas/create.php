<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ventas $model */

$this->title = 'Agregar Venta';
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ventas-create">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
