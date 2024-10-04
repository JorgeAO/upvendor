<?php

use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use kartik\icons\Icon;

Icon::map($this);

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="reportes-dashboard">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row">
        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <p>
                        <?= Html::a(Icon::show('arrow-right').'Ir a ventas', ['ventas/index'], ['class' => 'btn btn-sm btn-info float-right']) ?>
                    </p>
                    <br>
                    <?php
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'line',
                                'height' => 200,
                            ],
                            'title' => ['text' => 'Ventas de los Últimos 5 Días'],
                            'xAxis' => [
                                'categories' => array_column($ventasUltimos5Dias, 'dia'),
                                'labels' => ['style' => ['fontSize' => '10px']]
                            ],
                            'yAxis' => [
                                'title' => ['text' => 'Ventas'],
                                'labels' => ['style' => ['fontSize' => '10px']]
                            ],
                            'legend' => ['enabled' => false],
                            'plotOptions' => [
                                'line' => [
                                    'marker' => [
                                        'enabled' => true
                                    ]
                                ]
                            ],
                            'series' => [
                                [
                                    'name' => 'Ventas',
                                    'data' => array_column($ventasUltimos5Dias, 'total_ventas'),
                                    'color' => '#7cb5ec'
                                ]
                            ],
                            'credits' => ['enabled' => false]
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <p>
                        <?= Html::a(Icon::show('arrow-right').'Ir a compras', ['compras/index'], ['class' => 'btn btn-sm btn-info float-right']) ?>
                    </p><br>
                    <?php
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'line',
                                'height' => 200,
                            ],
                            'title' => ['text' => 'Compras de los Últimos 5 Días'],
                            'xAxis' => [
                                'categories' => array_column($comprasUltimos5Dias, 'dia'),
                                'labels' => ['style' => ['fontSize' => '10px']]
                            ],
                            'yAxis' => [
                                'title' => ['text' => 'Compras'],
                                'labels' => ['style' => ['fontSize' => '10px']]
                            ],
                            'legend' => ['enabled' => false],
                            'plotOptions' => [
                                'line' => [
                                    'marker' => [
                                        'enabled' => true
                                    ]
                                ]
                            ],
                            'series' => [
                                [
                                    'name' => 'Compras',
                                    'data' => array_column($comprasUltimos5Dias, 'total_compras'),
                                    'color' => '#7cb5ec'
                                ]
                            ],
                            'credits' => ['enabled' => false]
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <p>
                        <?= Html::a(Icon::show('arrow-right').'Ir a clientes', ['clientes/index'], ['class' => 'btn btn-sm btn-info float-right']) ?>
                    </p><br>
                    <?php
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => [
                                'type' => 'pie',
                                'height' => 300,
                            ],
                            'title' => ['text' => 'Clientes con más compras'],
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
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <p>
                        <?= Html::a(Icon::show('arrow-right').'Ir a productos', ['productos/index'], ['class' => 'btn btn-sm btn-info float-right']) ?>
                    </p><br>
                    <?php 
                        echo Highcharts::widget([
                            'options' => [
                                'chart' => [
                                    'type' => 'pie',
                                    'height' => 300,
                                ],
                                'title' => ['text' => 'Productos más vendidos en el último mes'],
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
                </div>
            </div>
        </div>

        <div class="col-sm-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <p>
                        <?= Html::a(Icon::show('arrow-right').'Ir a productos', ['productos/index'], ['class' => 'btn btn-sm btn-info float-right']) ?>
                    </p><br>
                    <?php 
                            echo Highcharts::widget([   
                            'options' => [
                                'chart' => [
                                    'type' => 'column',
                                    'height' => 300,
                                ],
                                'title' => ['text' => 'Productos próximos a agotarse'],
                                'xAxis' => [
                                    'categories' => array_column($productosVencidos, 'producto_nombre'),
                                ],
                                'yAxis' => [
                                    'title' => ['text' => 'Stock'],
                                    'min' => -10,
                                    'max' => 10
                                ],
                                'series' => [
                                    [
                                        'name' => 'Stock',
                                        'data' => array_map(function($producto) {
                                            return [
                                                'y' => (int)$producto['producto_stock'],
                                                'color' => '#36a2eb',
                                                'url' => \yii\helpers\Url::to(['productos/view', 'producto_id' => $producto['producto_id']])
                                            ];
                                        }, $productosVencidos)
                                    ]
                                ],
                                'tooltip' => [
                                    'pointFormat' => '{series.name}: <b>{point.y}</b>'
                                ],
                                'plotOptions' => [
                                    'column' => [
                                        'dataLabels' => [
                                            'enabled' => true,
                                            'format' => '{y}'
                                        ]
                                    ]
                                ],
                                'credits' => ['enabled' => false]
                            ],
                            'scripts' => [
                                'modules/exporting',
                                'modules/export-data',
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>