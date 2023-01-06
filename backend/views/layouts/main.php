<?php

use backend\controllers\PermisosController;
use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);

$arrMenu = PermisosController::construirMenu();

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

    <header>
        <?php
        if (isset($_SESSION['usuario_sesion']))
        {
            NavBar::begin([
                //'brandLabel' => Yii::$app->name,
                'brandLabel' => '<img src="logo_48x48.png"/>',
                'brandUrl' => '/site/index',
                'options' => [
                    'class' => 'navbar navbar-expand-md navbar-light fixed-top',
                    'style' => 'background-color: white'
                ],
            ]);

            echo Nav::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'navbar-nav'],
                'items' => $arrMenu,
            ]);
            NavBar::end();
        
        }
        ?>
    </header>

    <main role="main">
        <div class="col-sm-10 offset-sm-1" style="margin-top:70px;">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>

            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <?php $this->endBody() ?>
    </body>
</html>

<?php $this->endPage();?>
