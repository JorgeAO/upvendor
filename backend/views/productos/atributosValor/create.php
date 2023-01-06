<?php

use app\models\Atributos;
use yii\helpers\Html;

$atributo = Atributos::findOne($atributo_id);

$this->title = 'Agregar Valor de '.$atributo->atributo_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Atributos', 'url' => ['atributos/index']];
$this->params['breadcrumbs'][] = ['label' => 'Valores del Atributo: '.$atributo->atributo_descripcion, 'url' => ['index', 'atributo_id'=>$atributo_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atributos-valor-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'atributo_id' => $atributo_id,
    ]) ?>

</div>
