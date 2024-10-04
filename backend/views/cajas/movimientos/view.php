<?php

use app\models\Caja;
use app\models\TipoMovimiento;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\icons\Icon;

Icon::map($this);

$this->title = 'Movimiento #'.$model->movimiento_id;
$this->params['breadcrumbs'][] = ['label' => 'Movimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="movimientos-view">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
    </p>
    <div class="row">
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-bordered table-striped table-sm'],
                'attributes' => [   
                    'movimiento_id',
                    'movimiento_fecha',
                    [
                        'label' => 'Tipo de Movimiento',
                        'value' => function($model) {
                            return TipoMovimiento::find()->where(['tipomovi_id' => $model->fk_caj_tipo_movimiento])->one()->tipomovi_descripcion;
                        }
                    ],
                    [
                        'attribute' => 'fk_caj_cajas',
                        'value' => function($model) {
                            return Caja::find()->where(['caja_id' => $model->fk_caj_cajas])->one()->caja_descripcion;
                        }
                    ],
                    [
                        'label' => 'Monto',
                        'value' => function($data){
                            return Yii::$app->formatter->asCurrency($data->movimiento_monto, '$');
                        },
                    ],
                    'movimiento_observacion',
                    'fc',
                    'uc',
                ],
            ]) ?>
        </div>
    </div>
</div>
