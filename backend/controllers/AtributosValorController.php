<?php

namespace backend\controllers;

use app\models\AtributosValor;
use app\models\AtributosValorSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AtributosValorController extends Controller
{
    private $strRuta = "/productos/atributosValor/";
    private $intOpcion = 4006;

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

    public function actionView($atrivalor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($atrivalor_id),
        ]);
    }

    public function actionCreate($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new AtributosValor();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->atrivalor_valor = mb_strtoupper($model->atrivalor_valor, 'UTF-8');
            $model->fk_pro_atributos = $atributo_id;
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

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

    public function actionUpdate($atrivalor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($atrivalor_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->atrivalor_valor = mb_strtoupper($model->atrivalor_valor, 'UTF-8');
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'atrivalor_id' => $model->atrivalor_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($atrivalor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($atrivalor_id)->delete();

        return $this->redirect(['index']);
    }

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
