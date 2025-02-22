<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use miloschuman\highcharts\Highcharts;
use kartik\icons\Icon;

Icon::map($this);

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="reportes-dashboard">
    <h4><?= Html::encode($this->title) ?></h4>
    <?php $form = ActiveForm::begin(); ?>
        <div class="row mb-3">
            <div class="col-sm-4">
                <label for="fecha-inicial">Fecha Inicial</label>
                <?= DatePicker::widget([
                    'name' => 'fecha_inicial',
                    'options' => [
                        'class' => 'form-control form-control-sm',
                        'readonly' => true,
                        'value' => $model->fecha_inicial
                    ],
                    'clientOptions' => [
                        'changeMonth'=>true,
                        'changeYear'=>true,
                        'language' => 'es',
                        'maxDate' => '0',
                        'onChange' => new yii\web\JsExpression('function(dateText, inst) { validarFechas(); }'),
                    ],
                    'dateFormat' => 'php:Y-m-d',
                ]) ?>   
            </div>
            <div class="col-sm-4">
                <label for="fecha-final">Fecha Final</label>
                <?= DatePicker::widget([
                    'name' => 'fecha_final',
                    'options' => [
                        'class' => 'form-control form-control-sm',
                        'readonly' => true,
                        'value' => $model->fecha_final
                    ],
                    'clientOptions' => [
                        'changeMonth'=>true,
                        'changeYear'=>true,
                        'language' => 'es',
                        'maxDate' => '0',
                        'onSelect' => new yii\web\JsExpression('function(dateText, inst) { validarFechas(); }'),
                    ],
                    'dateFormat' => 'php:Y-m-d',
                ]) ?> 
            </div>
            <div class="col-sm-4">
                <?= Html::submitButton(Icon::show('chart-line').' Generar', ['class' => 'btn btn-sm btn-azul mt-4']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>

    <?php if (isset($data['error']) && $data['error']): ?>
        <div class="alert alert-danger">
            <?= $data['mensaje'] ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <label class="card-db-title"><?= Icon::show('shopping-bag') ?> Ventas</label>
                    <h3>$<?= number_format($totalVentas, 2, ',', '.') ?></h3>
                    <?= Html::a(Icon::show('arrow-right').'Ir a ventas', ['ventas/index'], ['class' => 'card-link']) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <label class="card-db-title"><?= Icon::show('cart-arrow-down') ?> Compras</label>
                    <h3>$<?= number_format($totalCompras, 2, ',', '.') ?></h3>
                    <?= Html::a(Icon::show('arrow-right').'Ir a compras', ['compras/index'], ['class' => 'card-link']) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <label class="card-db-title"><?= Icon::show('users') ?> Clientes con más compras</label>
                    <?php
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'height' => 300,
                            ],
                            'title' => ['text' => ''],
                            'plotOptions' => [
                                'pie' => [
                                    'allowPointSelect' => true,
                                    'cursor' => 'pointer',
                                    'dataLabels' => [
                                        'enabled' => true,
                                        'format' => '<b>{point.name}</b>: {point.percentage:.1f} %'
                                    ]
                                ]
                            ],
                            'series' => [[
                                'name' => 'Compras',
                                'colorByPoint' => true,
                                'data' => array_map(function($cliente) {
                                    return [
                                        'name' => $cliente['cliente_nombre_completo'],
                                        'y' => (int)$cliente['total_compras'],
                                        'url' => \yii\helpers\Url::to(['cliente/view', 'cliente_id' => $cliente['cliente_id']])
                                    ];
                                }, $clientesMasCompras)
                            ]],
                            'tooltip' => [
                                'pointFormat' => '{series.name}: <b>{point.y}</b>'
                            ],
                            'credits' => ['enabled' => false]
                        ],
                        'scripts' => [
                            'modules/exporting',
                            'modules/export-data',
                        ],
                    ]);
                    ?>
                    <?= Html::a(Icon::show('arrow-right').'Ir a clientes', ['clientes/index'], ['class' => 'card-link']) ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <label class="card-db-title"><?= Icon::show('chart-pie') ?> Productos más vendidos</label>
                    <?php 
                        echo Highcharts::widget([
                            'options' => [
                                'chart' => [
                                    'type' => 'pie',
                                    'height' => 300,
                                ],
                                'title' => ['text' => ''],
                                'plotOptions' => [
                                    'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor' => 'pointer',
                                        'dataLabels' => [
                                            'enabled' => true,
                                            'format' => '<b>{point.name}</b>: {point.percentage:.1f} %'
                                        ]
                                    ]
                                ],
                                'series' => [[
                                    'name' => 'Ventas',
                                    'colorByPoint' => true,
                                    'data' => array_map(function($producto) {
                                        return [
                                            'name' => $producto['producto_nombre'],
                                            'y' => (int)$producto['total_ventas'],
                                            'url' => \yii\helpers\Url::to(['productos/view', 'producto_id' => $producto['producto_id']])
                                        ];
                                    }, $productosMasVendidos)
                                ]],
                                'tooltip' => [
                                    'pointFormat' => '{series.name}: <b>{point.y}</b>'
                                ],
                                'credits' => ['enabled' => false]
                            ],
                            'scripts' => [
                                'modules/exporting',
                                'modules/export-data',
                            ],
                        ]);
                    ?>
                    <?= Html::a(Icon::show('arrow-right').'Ir a productos', ['productos/index'], ['class' => 'card-link']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function validarFechas() {
        var fechaInicial = document.getElementsByName('fecha_inicial')[0].value;
        var fechaFinal = document.getElementsByName('fecha_final')[0].value;

        if (fechaInicial > fechaFinal) {
            alert('La fecha inicial no puede ser mayor a la fecha final');
            document.getElementsByName('fecha_final')[0].value = '';
        }
    }
</script>