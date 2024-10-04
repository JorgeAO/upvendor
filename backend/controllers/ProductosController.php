<?php

namespace backend\controllers;

use app\models\Productos;
use app\models\ProductosAtributos;
use app\models\ProductosSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProductosController extends Controller
{
    private $strRuta = "/productos/productos/";
    private $intOpcion = 4004;

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
    
    public function actionView($producto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        // Consulta al modelo ProductosAtributos
        $atributos = ProductosAtributos::find()
            ->select([
                'pa.*',
                'atr.atributo_descripcion',
                'av.atrivalor_valor'
            ])
            ->from(['pa' => ProductosAtributos::tableName()])
            ->join('JOIN', ['atr' => 'tb_pro_atributos'], 'atr.atributo_id = pa.fk_pro_atributos')
            ->join('JOIN', ['av' => 'tb_pro_atributos_valor'], 'pa.fk_pro_atributos_valor = av.atrivalor_id')
            ->where(['pa.fk_pro_productos' => $producto_id])
            ->all();
        
        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($producto_id),
            'atributos' => $atributos
        ]);
    }
    
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Productos();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->producto_nombre = mb_strtoupper($model->producto_nombre);
            $model->producto_descripcion = mb_strtoupper($model->producto_descripcion);
            $model->producto_referencia = mb_strtoupper($model->producto_referencia);
            $model->productos_precio_con_imp = 1;
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

            $model->save();

            if (isset($this->request->post()["atributos"])) {
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
    
    public function actionUpdate($producto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($producto_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->producto_nombre = mb_strtoupper($model->producto_nombre);
            $model->producto_descripcion = mb_strtoupper($model->producto_descripcion);
            $model->producto_referencia = mb_strtoupper($model->producto_referencia);
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];

            $model->save();

            $sqlSentencia = "delete from tb_pro_productos_atributos where fk_pro_productos = ".$producto_id.";";
            $cnxConexion = Yii::$app->db;
            $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
            $atributos = $stmtSentencia->queryAll();
            

            if (isset($this->request->post()["atributos"])) {
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
            }
            
            return $this->redirect(['view', 'producto_id' => $model->producto_id]);
        }

        // Consulta al modelo ProductosAtributos
        $atributos = ProductosAtributos::find()
            ->select([
                'pa.*',
                'atr.atributo_descripcion',
                'av.atrivalor_valor'
            ])
            ->from(['pa' => ProductosAtributos::tableName()])
            ->join('JOIN', ['atr' => 'tb_pro_atributos'], 'atr.atributo_id = pa.fk_pro_atributos')
            ->join('JOIN', ['av' => 'tb_pro_atributos_valor'], 'pa.fk_pro_atributos_valor = av.atrivalor_id')
            ->where(['pa.fk_pro_productos' => $producto_id])
            ->all();

        return $this->render($this->strRuta.'update', [
            'model' => $model,
            'atributos' => $atributos,
        ]);
    }
    
    public function actionDelete($producto_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($producto_id)->delete();

        return $this->redirect(['index']);
    }
    
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

    public function actionObtenerPrecioVenta()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $producto_id = Yii::$app->request->post()['producto_id'];
        $producto = Productos::findOne($producto_id);

        echo json_encode($producto->producto_precioventa);
    }
        
}
