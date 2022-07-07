<?php
use yii\helpers\Html;

$this->title = 'Agregar Tipo de Persona';
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Persona', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-persona-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
