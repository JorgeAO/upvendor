<?php

namespace backend\controllers;

use app\models\Atributos;
use app\models\AtributosSearch;
use app\models\AtributosValorSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AtributosController implements the CRUD actions for Atributos model.
 */
class AtributosController extends Controller
{
    private $strRuta = "/productos/atributos/";
    private $intOpcion = 4005;

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
     * Lists all Atributos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new AtributosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Atributos model.
     * @param int $atributo_id Atributo ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($atributo_id),
        ]);
    }

    /**
     * Creates a new Atributos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Atributos();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

            if ($model->save()) {
                return $this->redirect(['view', 'atributo_id' => $model->atributo_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Atributos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $atributo_id Atributo ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($atributo_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'atributo_id' => $model->atributo_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Atributos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $atributo_id Atributo ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($atributo_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Atributos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $atributo_id Atributo ID
     * @return Atributos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($atributo_id)
    {
        if (($model = Atributos::findOne(['atributo_id' => $atributo_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionValores($atributo_id)
    {
        $rta = PermisosController::validarPermiso(4006, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new AtributosValorSearch();
        $searchModel->fk_pro_atributos = $atributo_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('/productos/atributosValor/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'atributo_id' => $atributo_id
        ]);
    }

    public function actionListar()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'l');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlWhere = '';

        foreach (Yii::$app->request->post() as $key => $value) 
        {
            if ($value != '')
            {
                $sqlWhere .= $key." = '".$value."' and ";
            }
        }

        $sqlWhere = $sqlWhere != '' ? rtrim($sqlWhere, " and ") : "";

        $sqlSentencia = "select * from tb_pro_atributos";
        $sqlSentencia = $sqlWhere != '' ? $sqlSentencia." where ".$sqlWhere.";" : $sqlSentencia;

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $atributos = $stmtSentencia->queryAll();
        
        echo json_encode($atributos);
    }
}