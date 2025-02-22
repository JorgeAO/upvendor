<?php

namespace backend\controllers;

use app\models\TipoMovimiento;
use app\models\TipoMovimientoSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TipoMovimientoController extends Controller
{
    private $strRuta = '/cajas/tipo-movimiento/';
    private $intOpcion = 8002;

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

        $searchModel = new TipoMovimientoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($tipomovi_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($tipomovi_id),
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new TipoMovimiento();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->tipomovi_descripcion = mb_strtoupper($model->tipomovi_descripcion);
                $model->fk_par_estados = 1;
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                if ($model->save()) {
                    return $this->redirect(['view', 'tipomovi_id' => $model->tipomovi_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($tipomovi_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($tipomovi_id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->tipomovi_descripcion = mb_strtoupper($model->tipomovi_descripcion);
                $model->fm = date('Y-m-d H:i:s');
                $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];

                if ($model->save()) {
                    return $this->redirect(['view', 'tipomovi_id' => $model->tipomovi_id]);
                }
            }
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($tipomovi_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($tipomovi_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($tipomovi_id)
    {
        if (($model = TipoMovimiento::findOne(['tipomovi_id' => $tipomovi_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página que buscas no existe.');
    }
}
