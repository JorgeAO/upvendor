<?php

use yii\helpers\Html;

$this->title = 'Agregar Movimiento';
$this->params['breadcrumbs'][] = ['label' => 'Movimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movimientos-create">
    <h4><?= Html::encode($this->title) ?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php if (isset($data['error']) && $data['error']): ?>
        <div class="alert alert-danger">
            <?= $data['mensaje'] ?>
        </div>
    <?php endif; ?>
</div>
