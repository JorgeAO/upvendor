<?php

namespace backend\controllers;

use app\models\Impuestos;
use app\models\ImpuestosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImpuestosController implements the CRUD actions for Impuestos model.
 */
class ImpuestosController extends Controller
{
    private $strRuta = "/productos/impuestos/";
    private $intOpcion = 4002;

    /**
     * @inheritDoc
     */
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

    /**
     * Lists all Impuestos models.
     *
     * @return string
     */
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

    /**
     * Displays a single Impuestos model.
     * @param int $impuesto_id Código
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($impuesto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($impuesto_id),
        ]);
    }

    /**
     * Creates a new Impuestos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Impuestos();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'impuesto_id' => $model->impuesto_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Impuestos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $impuesto_id Código
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($impuesto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($impuesto_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'impuesto_id' => $model->impuesto_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Impuestos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $impuesto_id Código
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($impuesto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($impuesto_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Impuestos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $impuesto_id Código
     * @return Impuestos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($impuesto_id)
    {
        if (($model = Impuestos::findOne(['impuesto_id' => $impuesto_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
