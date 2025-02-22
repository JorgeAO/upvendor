<?php

namespace backend\controllers;

use app\models\Caja;
use app\models\CajaSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CajaController extends Controller
{
    private $strRuta = "/cajas/caja/";
    private $intOpcion = 8001;

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

        $searchModel = new CajaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $totalEnCaja = Caja::find()->where(['fk_par_estado' => 1])->sum('caja_monto');

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'totalEnCaja' => $totalEnCaja,
        ]);
    }

    public function actionView($caja_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($caja_id),
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Caja();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())){
                $model->caja_descripcion = mb_strtoupper($model->caja_descripcion);
                $model->fk_par_estado = 1; 
                $model->caja_monto = str_replace(',', '', $model->caja_monto);
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                if ($model->save()) {
                    return $this->redirect(['view', 'caja_id' => $model->caja_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($caja_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($caja_id);

        if ($this->request->isPost && $model->load($this->request->post())){
            $model->caja_descripcion = mb_strtoupper($model->caja_descripcion);
            $model->caja_monto = str_replace(',', '', $model->caja_monto);
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];

            if ($model->save()) {
                return $this->redirect(['view', 'caja_id' => $model->caja_id]);
            }
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($caja_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($caja_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($caja_id)
    {
        if (($model = Caja::findOne(['caja_id' => $caja_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
