<?php

namespace backend\controllers;

use app\models\TipoIdentificacion;
use app\models\TipoIdentificacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoIdentificacionController implements the CRUD actions for TipoIdentificacion model.
 */
class TipoIdentificacionController extends Controller
{
    private $strRuta = "/parametros/tipoIdentificacion/";
    private $intOpcion = 2001;

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
     * Lists all TipoIdentificacion models.
     *
     * @return string
     */
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

    /**
     * Displays a single TipoIdentificacion model.
     * @param int $tipoiden_id Tipoiden ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($tipoiden_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($tipoiden_id),
        ]);
    }

    /**
     * Creates a new TipoIdentificacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new TipoIdentificacion();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

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

    /**
     * Updates an existing TipoIdentificacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $tipoiden_id Tipoiden ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($tipoiden_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($tipoiden_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'tipoiden_id' => $model->tipoiden_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoIdentificacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $tipoiden_id Tipoiden ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($tipoiden_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($tipoiden_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoIdentificacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $tipoiden_id Tipoiden ID
     * @return TipoIdentificacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tipoiden_id)
    {
        if (($model = TipoIdentificacion::findOne(['tipoiden_id' => $tipoiden_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
