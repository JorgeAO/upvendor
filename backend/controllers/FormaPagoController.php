<?php

namespace backend\controllers;

use app\models\FormaPago;
use app\models\FormaPagoSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FormaPagoController extends Controller
{
    private $strRuta = "/parametros/forma-pago/";
    private $intOpcion = 2003;

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

        $searchModel = new FormaPagoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($formpago_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($formpago_id),
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new FormaPago();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())){
                $model->formpago_descripcion = strtoupper($model->formpago_descripcion);
                $model->fk_par_estados = 1;
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                if($model->save()){
                    return $this->redirect(['view', 'formpago_id' => $model->formpago_id]);
                }
            }
        }
        
        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($formpago_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($formpago_id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())){
                $model->formpago_descripcion = strtoupper($model->formpago_descripcion);
                $model->fm = date('Y-m-d H:i:s');
                $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];

                if($model->save()){
                    return $this->redirect(['view', 'formpago_id' => $model->formpago_id]);
                }
            }
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($formpago_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($formpago_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($formpago_id)
    {
        if (($model = FormaPago::findOne(['formpago_id' => $formpago_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
