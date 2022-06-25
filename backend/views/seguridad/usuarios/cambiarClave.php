<?php

use yii\helpers\Html;

$this->title = 'Cambiar Clave';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-create">

    <h4><?= Html::encode($this->title) ?></h4>

    <pre>
    <?php
    print_r($model);
    ?>
    </pre>

</div>