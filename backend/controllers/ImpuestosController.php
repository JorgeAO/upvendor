<?php

namespace backend\controllers;

use app\models\Impuestos;
use app\models\ImpuestosSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ImpuestosController extends Controller
{
    private $strRuta = "/productos/impuestos/";
    private $intOpcion = 4002;

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

        $searchModel = new ImpuestosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($impuesto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($impuesto_id),
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Impuestos();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->impuesto_descripcion = mb_strtoupper($model->impuesto_descripcion, 'UTF-8');
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];
            $model->save();

            return $this->redirect(['view', 'impuesto_id' => $model->impuesto_id]);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($impuesto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($impuesto_id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->impuesto_descripcion = mb_strtoupper($model->impuesto_descripcion, 'UTF-8');
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];

            $model->save();
            return $this->redirect(['view', 'impuesto_id' => $model->impuesto_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($impuesto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($impuesto_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($impuesto_id)
    {
        if (($model = Impuestos::findOne(['impuesto_id' => $impuesto_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCalcular()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel(Yii::$app->request->post()['impuesto_id']);
        
        echo json_encode($model->impuesto_porcentaje);
    }
}
