<?php

use app\models\Estados;
use app\models\Perfiles;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\widgets\DetailView;

Icon::map($this);

$this->title = $model->usuarios_id.' - '.$model->usuarios_nombre.' '.$model->usuarios_apellido;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Icon::show('arrow-left').' Volver', ['index'], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show('plus').' Agregar', ['create'], ['class' => 'btn btn-azul btn-sm']) ?>
        <?= Html::a(Icon::show("pencil-alt").' Editar', ['update', 'usuarios_id' => $model->usuarios_id], ['class' => 'btn btn-sm btn-azul']) ?>
        <?= Html::a(Icon::show("trash").' Eliminar', ['delete', 'usuarios_id' => $model->usuarios_id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => '¿Está seguro que desea eliminar el registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'usuarios_id',
            'usuarios_nombre',
            'usuarios_apellido',
            'usuarios_telefono',
            'usuarios_correo',
            [
                'label'=>'Perfil',
                'value'=>function($data){
                    return Perfiles::find()->where(['perfiles_id'=>$data->fk_seg_perfiles])->all()[0]->perfiles_descripcion;
                }
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