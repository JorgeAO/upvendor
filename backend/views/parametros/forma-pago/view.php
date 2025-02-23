<?php
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Caja;
use yii\helpers\ArrayHelper;

Icon::map($this);

$this->title = $model->formpago_id.' - '.$model->formpago_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Forma de Pago', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forma-pago-view">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'formpago_id' => $model->formpago_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'formpago_id' => $model->formpago_id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-sm-6">
            <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-striped table-hover table-sm'],
                    'attributes' => [
                        'formpago_id',
                        'formpago_descripcion',
                        [
                            'label'=>'Caja',
                            'value'=>function($data){
                                $caja = Caja::find()->where(['caja_id' => $data->fk_caj_cajas])->one();
                                return $caja ? $caja->caja_descripcion : 'NO HAY CAJA ASIGNADA';
                            },
                            'attribute'=>'fk_caj_cajas',
                            'filter'=>ArrayHelper::map(Caja::find()->asArray()->all(), 'caja_id', 'caja_descripcion'),
                        ],
                        [
                        'label'=>'Estado',
                        'value'=>function($data){
                            return Estados::find()->where(['estados_id'=>$data->fk_par_estados])->all()[0]->estados_descripcion;
                        }
                    ],
                    'fc',
                    'uc',
                    'fm',
                    'um',
                ],
            ]) ?>
        </div>
    </div>
</div>