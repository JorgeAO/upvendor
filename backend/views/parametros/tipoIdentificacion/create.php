<?php
use yii\helpers\Html;

$this->title = 'Agregar Tipo de Identificación';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Identificación', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-identificacion-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
