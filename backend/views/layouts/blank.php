<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

$this->title = 'Bienvenido';

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
        <main role="main">
            <div class="container">
                <div class="jumbotron text-center bg-transparent">
                    <h1 class="display-4"><?= $this->title ?></h1>
                    <p class="lead"><?= Yii::$app->name ?></p>
                </div>
            </div>
        </main>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage(); ?>
