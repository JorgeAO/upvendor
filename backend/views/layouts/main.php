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
        if (isset($_SESSION['as_usuario_sesion']))
        {
            NavBar::begin([
                'brandLabel' => '<img src="logo_48x48.png"/>',
                'brandUrl' => '#',
                'options' => [
                    'class' => 'navbar navbar-expand-md navbar-light bg-white fixed-top',
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

            <div class="alert alert-light" style="font-size:14px" role="alert">
                <?php
                    if (isset($_SESSION['as_usuario_sesion'])) {
                        $fechaActual = date('Y-m-d');
                        echo $fechaActual . ' <span id="reloj"></span>';
                    }
                ?>
                
                <script>
                function actualizarReloj() {
                    var ahora = new Date();
                    var horas = ahora.getHours();
                    var minutos = ahora.getMinutes();
                    var segundos = ahora.getSeconds();
                    var ampm = horas >= 12 ? 'PM' : 'AM';
                    horas = horas % 12;
                    horas = horas ? horas : 12;
                    minutos = minutos < 10 ? '0'+minutos : minutos;
                    segundos = segundos < 10 ? '0'+segundos : segundos;
                    var horaString = horas + ':' + minutos + ':' + segundos + ' ' + ampm;
                    document.getElementById('reloj').innerHTML = horaString;
                    setTimeout(actualizarReloj, 1000);
                }
                actualizarReloj();
                </script>
            </div>

            <?= $content ?>
        </div>
    </main>

    <?php $this->endBody() ?>
    </body>
</html>

<?php $this->endPage();?>