<?php

namespace backend\controllers;

use app\models\TipoIdentificacion;
use app\models\TipoIdentificacionSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TipoIdentificacionController extends Controller
{
    private $strRuta = "/parametros/tipoIdentificacion/";
    private $intOpcion = 2001;

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new TipoIdentificacionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($tipoiden_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($tipoiden_id),
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new TipoIdentificacion();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->tipoiden_descripcion = mb_strtoupper($model->tipoiden_descripcion, 'UTF-8');
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

            if ($model->save()) {
                return $this->redirect(['view', 'tipoiden_id' => $model->tipoiden_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($tipoiden_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($tipoiden_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->tipoiden_descripcion = mb_strtoupper($model->tipoiden_descripcion, 'UTF-8');
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'tipoiden_id' => $model->tipoiden_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($tipoiden_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($tipoiden_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($tipoiden_id)
    {
        if (($model = TipoIdentificacion::findOne(['tipoiden_id' => $tipoiden_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
