<?php
use yii\helpers\Html;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($data['mensaje'])); ?>
    </div>

    <div>
        <?php
            if (isset($data['datos']['url']))
            {
                echo "<br><br>";
                echo Html::a($data['datos']['enlace'], $data['datos']['url'], ['class' => 'btn btn-sm btn-personalizado']);
            }
        ?>
    </div>

</div>
