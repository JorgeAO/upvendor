<?php

namespace backend\controllers;

use app\models\Atributos;
use app\models\AtributosSearch;
use app\models\AtributosValorSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AtributosController extends Controller
{
    private $strRuta = "/productos/atributos/";
    private $intOpcion = 4005;

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'listar' => ['POST'],
                    ],
                ],
            ]
        );
    }

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

    public function actionView($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($atributo_id),
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Atributos();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

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

    public function actionUpdate($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($atributo_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'atributo_id' => $model->atributo_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($atributo_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($atributo_id)->delete();

        return $this->redirect(['index']);
    }

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