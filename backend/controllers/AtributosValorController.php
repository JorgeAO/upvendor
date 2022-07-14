<?php

namespace backend\controllers;

use app\models\AtributosValor;
use app\models\AtributosValorSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AtributosValorController implements the CRUD actions for AtributosValor model.
 */
class AtributosValorController extends Controller
{
    private $strRuta = "/productos/atributosValor/";
    private $intOpcion = 4006;

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
     * Lists all AtributosValor models.
     *
     * @return string
     */
    public function actionIndex($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new AtributosValorSearch();
        $searchModel->fk_pro_atributos = $atributo_id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'atributo_id' => $atributo_id
        ]);
    }

    /**
     * Displays a single AtributosValor model.
     * @param int $atrivalor_id Atrivalor ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($atrivalor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($atrivalor_id),
        ]);
    }

    /**
     * Creates a new AtributosValor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new AtributosValor();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fk_pro_atributos = $atributo_id;
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

            if ($model->save()) {
                return $this->redirect([
                    'view', 
                    'atrivalor_id' => $model->atrivalor_id,
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
            'atributo_id' => $atributo_id,
        ]);
    }

    /**
     * Updates an existing AtributosValor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $atrivalor_id Atrivalor ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($atrivalor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($atrivalor_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'atrivalor_id' => $model->atrivalor_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AtributosValor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $atrivalor_id Atrivalor ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($atrivalor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($atrivalor_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AtributosValor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $atrivalor_id Atrivalor ID
     * @return AtributosValor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($atrivalor_id)
    {
        if (($model = AtributosValor::findOne(['atrivalor_id' => $atrivalor_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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

        $sqlSentencia = "select * from tb_pro_atributos_valor";
        $sqlSentencia = $sqlWhere != '' ? $sqlSentencia." where ".$sqlWhere.";" : $sqlSentencia;

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $atributosValor = $stmtSentencia->queryAll();
        
        echo json_encode($atributosValor);
    }
}
