<?php
namespace backend\controllers;

use app\models\TipoPersona;
use app\models\TipoPersonaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoPersonaController implements the CRUD actions for TipoPersona model.
 */
class TipoPersonaController extends Controller
{
    private $strRuta = "/parametros/tipoPersona/";
    private $intOpcion = 2002;

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
     * Lists all TipoPersona models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new TipoPersonaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoPersona model.
     * @param int $tipopers_id Tipopers ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($tipopers_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($tipopers_id),
        ]);
    }

    /**
     * Creates a new TipoPersona model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new TipoPersona();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

            if ($model->save()) {
                return $this->redirect(['view', 'tipopers_id' => $model->tipopers_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TipoPersona model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $tipopers_id Tipopers ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($tipopers_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($tipopers_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'tipopers_id' => $model->tipopers_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TipoPersona model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $tipopers_id Tipopers ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($tipopers_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($tipopers_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoPersona model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $tipopers_id Tipopers ID
     * @return TipoPersona the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tipopers_id)
    {
        if (($model = TipoPersona::findOne(['tipopers_id' => $tipopers_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
