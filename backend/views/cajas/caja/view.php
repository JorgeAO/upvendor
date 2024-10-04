<?php
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = $model->caja_id.' - '.$model->caja_descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Cajas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="caja-view">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show('pencil-alt').' Editar', ['update', 'caja_id' => $model->caja_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?php 
            if ($model->caja_monto == 0) {
                echo Html::a(Icon::show('trash').' Eliminar', ['delete', 'caja_id' => $model->caja_id], [
                    'class' => 'btn btn-sm btn-danger',
                    'data' => [
                        'confirm' => '¿Está seguro que desea eliminar el registro?',
                        'method' => 'post',
                    ],
                ]);
            } 
        ?>
    </p>
    <div class="row">
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-hover table-sm'],
                'attributes' => [
                    'caja_id',
                    'caja_descripcion',
                    [
                        'label' => 'Monto',
                        'value' => function($data){
                            return Yii::$app->formatter->asCurrency($data->caja_monto, '$');
                        },
                    ],
                    [
                        'label'=>'Estado',
                        'value'=>function($data){
                            return Estados::find()->where(['estados_id'=>$data->fk_par_estado])->all()[0]->estados_descripcion;
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
