<?php
use yii\helpers\Html;

$this->title = 'Agregar Atributo';
$this->params['breadcrumbs'][] = ['label' => 'Atributos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atributos-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
