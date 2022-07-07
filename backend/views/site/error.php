<?php
use yii\helpers\Html;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($data['mensaje'])) ?>
    </div>

</div>
