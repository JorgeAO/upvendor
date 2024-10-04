<?php
use app\models\TipoIdentificacion;
use app\models\Estados;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

Icon::map($this);

$this->title = $model->vendedor_id.' - '.$model->vendedor_nombre_completo;
$this->params['breadcrumbs'][] = ['label' => 'Vendedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vendedores-view">
    <h4><?= Html::encode($this->title) ?></h4>  
    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'vendedor_id' => $model->vendedor_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'vendedor_id' => $model->vendedor_id], [
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
                    'vendedor_id',
                    [
                        'label' => 'Tipo de Identificación',
                        'value' => function($data){
                            return TipoIdentificacion::find()->where(['tipoiden_id'=>$data->fk_par_tipo_identificacion])->all()[0]->tipoiden_descripcion;
                        }
                    ],
                    'vendedor_identificacion',
                    'vendedor_nombre_completo',
                    'vendedor_correo_electronico',
                    'vendedor_telefono',
                    'vendedor_direccion',
                    [
                        'label' => 'Estado',
                        'value' => function($data){
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