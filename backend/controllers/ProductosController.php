<?php

namespace backend\controllers;

use app\models\Productos;
use app\models\ProductosAtributos;
use app\models\ProductosSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductosController implements the CRUD actions for Productos model.
 */
class ProductosController extends Controller
{
    private $strRuta = "/productos/productos/";
    private $intOpcion = 4004;

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Productos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new ProductosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Productos model.
     * @param int $producto_id Producto ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($producto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlSentencia = "select 
            pa.*,
            atr.atributo_descripcion,
            av.atrivalor_valor
            from tb_pro_productos_atributos pa
            join tb_pro_atributos atr on (atr.atributo_id = pa.fk_pro_atributos)
            join tb_pro_atributos_valor av on (pa.fk_pro_atributos_valor = av.atrivalor_id)
            where pa.fk_pro_productos = ".$producto_id.";";

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $atributos = $stmtSentencia->queryAll();
        
        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($producto_id),
            'atributos' => $atributos
        ]);
    }

    /**
     * Creates a new Productos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Productos();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

            $model->save();

            foreach ($this->request->post()['atributos'] as $key => $value)
            {
                $productoAtributo = new ProductosAtributos();
                $productoAtributo->fk_pro_productos = $model->producto_id;
                $productoAtributo->fk_pro_atributos = $value['atributo_'.$key];
                $productoAtributo->fk_pro_atributos_valor = $value['atrivalor_'.$key];
                $productoAtributo->fc = date('Y-m-d H:i:s');;
                $productoAtributo->uc = $_SESSION['usuario_sesion']['usuarios_id'];

                $productoAtributo->save();
            }
            
            return $this->redirect(['view', 'producto_id' => $model->producto_id]);
        }
        else
        {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Productos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $producto_id Producto ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($producto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($producto_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];

            $model->save();

            $sqlSentencia = "delete from tb_pro_productos_atributos where fk_pro_productos = ".$producto_id.";";
            $cnxConexion = Yii::$app->db;
            $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
            $atributos = $stmtSentencia->queryAll();

            foreach ($this->request->post()['atributos'] as $key => $value)
            {
                $productoAtributo = new ProductosAtributos();
                $productoAtributo->fk_pro_productos = $model->producto_id;
                $productoAtributo->fk_pro_atributos = $value['atributo_'.$key];
                $productoAtributo->fk_pro_atributos_valor = $value['atrivalor_'.$key];
                $productoAtributo->fc = date('Y-m-d H:i:s');;
                $productoAtributo->uc = $_SESSION['usuario_sesion']['usuarios_id'];

                $productoAtributo->save();
            }
            
            return $this->redirect(['view', 'producto_id' => $model->producto_id]);
        }

        $sqlSentencia = "select 
            pa.*,
            atr.atributo_descripcion,
            av.atrivalor_valor
            from tb_pro_productos_atributos pa
            join tb_pro_atributos atr on (atr.atributo_id = pa.fk_pro_atributos)
            join tb_pro_atributos_valor av on (pa.fk_pro_atributos_valor = av.atrivalor_id)
            where pa.fk_pro_productos = ".$producto_id.";";

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $atributos = $stmtSentencia->queryAll();

        return $this->render($this->strRuta.'update', [
            'model' => $model,
            'atributos' => $atributos,
        ]);
    }

    /**
     * Deletes an existing Productos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $producto_id Producto ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($producto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($producto_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $producto_id Producto ID
     * @return Productos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($producto_id)
    {
        if (($model = Productos::findOne(['producto_id' => $producto_id])) !== null) {
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
                if (in_array($key[0], array('>', '<', '*', '~')))
                {
                    $sqlWhere .= substr($key, 1, strlen($key))." ".$key[0]." '".$value."' and ";
                }
                else
                {
                    $sqlWhere .= $key." = '".$value."' and ";
                }
            }
        }
        
        $sqlWhere = $sqlWhere != '' ? rtrim($sqlWhere, " and ") : "";

        $sqlSentencia = "select * from tb_pro_productos";
        $sqlSentencia = $sqlWhere != '' ? $sqlSentencia." where ".$sqlWhere.";" : $sqlSentencia;

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $resultado = $stmtSentencia->queryAll();
        
        echo json_encode($resultado);
    }
}
