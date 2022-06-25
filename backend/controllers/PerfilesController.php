<?php

namespace backend\controllers;

use app\models\Perfiles;
use app\models\PerfilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PerfilesController implements the CRUD actions for Perfiles model.
 */
class PerfilesController extends Controller
{
    private $strRuta = "/seguridad/perfiles/";
    private $intOpcion = 1001;

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
     * Lists all Perfiles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);
            
        $searchModel = new PerfilesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Perfiles model.
     * @param int $perfiles_id Código
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($perfiles_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($perfiles_id),
        ]);
    }

    /**
     * Creates a new Perfiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Perfiles();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'perfiles_id' => $model->perfiles_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Perfiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $perfiles_id Código
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($perfiles_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($perfiles_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'perfiles_id' => $model->perfiles_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Perfiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $perfiles_id Código
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($perfiles_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($perfiles_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Perfiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $perfiles_id Código
     * @return Perfiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($perfiles_id)
    {
        if (($model = Perfiles::findOne(['perfiles_id' => $perfiles_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}