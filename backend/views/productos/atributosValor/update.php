<?php

use app\models\Atributos;
use yii\helpers\Html;

$atributo = Atributos::findOne($model->fk_pro_atributos);

$this->title = 'Editar Valor del Atributo '.$atributo->atributo_descripcion.': '. $model->atrivalor_id.' - '.$model->atrivalor_valor;
$this->params['breadcrumbs'][] = ['label' => 'Atributos', 'url' => ['atributos/index']];
$this->params['breadcrumbs'][] = ['label' => 'Valores del Atributo: '.$atributo->atributo_descripcion, 'url' => ['index', 'atributo_id'=>$atributo->atributo_id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="atributos-valor-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'atributo_id' => $model->fk_pro_atributos,
    ]) ?>

</div>
