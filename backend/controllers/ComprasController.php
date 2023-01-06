<?php

namespace backend\controllers;

use app\models\Compras;
use app\models\ComprasProductos;
use app\models\ComprasSearch;
use app\models\Proveedores;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComprasController implements the CRUD actions for Compras model.
 */
class ComprasController extends Controller
{
    private $strRuta = "/compras/compras/";
    private $intOpcion = 5001;

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
     * Lists all Compras models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new ComprasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Compras model.
     * @param int $compra_id Compra ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($compra_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlSentencia = "select 
                cp.*,
                p.producto_nombre
            from tb_com_compras_productos cp
            join tb_pro_productos p on (p.producto_id = cp.fk_pro_productos)
            where cp.fk_com_compras = ".$compra_id.";";

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $productos = $stmtSentencia->queryAll();

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($compra_id),
            'productos' => $productos,
        ]);
    }

    /**
     * Creates a new Compras model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Compras();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $proveedorIdentificacion = explode(' - ', $model->fk_pro_proveedores)[0];
            $proveedor = Proveedores::find()->select('proveedor_id')->where(['proveedor_identificacion' => $proveedorIdentificacion])->all();

            $model->fk_pro_proveedores = $proveedor[0]->proveedor_id;
            $model->fk_com_estados_compra = 1; // Estado de la compra: 1 - Borrador
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

            $model->save();

            foreach ($this->request->post()['productos'] as $key => $value)
            {
                $compraProducto = new ComprasProductos();
                $compraProducto->fk_com_compras = $model->compra_id;
                $compraProducto->fk_pro_productos = $value['producto_'.$key];
                $compraProducto->comprod_cantidad = $value['cantidad_'.$key];
                $compraProducto->comprod_vlr_unitario = $value['vlr_unit_'.$key];
                $compraProducto->comprod_vlr_total = $value['vlr_total_'.$key];
                $compraProducto->comprod_dcto = $value['dcto_'.$key];
                $compraProducto->comprod_vlr_final = $value['vlr_final_'.$key];
                $compraProducto->comprod_entregado = 0;
                $compraProducto->fc = date('Y-m-d H:i:s');
                $compraProducto->uc = $_SESSION['usuario_sesion']['usuarios_id'];

                $compraProducto->save();
            }

            return $this->redirect(['view', 'compra_id' => $model->compra_id]);
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
     * Updates an existing Compras model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $compra_id Compra ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($compra_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($compra_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $proveedorIdentificacion = explode(' - ', $model->fk_pro_proveedores)[0];
            $proveedor = Proveedores::find()->select('proveedor_id')->where(['proveedor_identificacion' => $proveedorIdentificacion])->all();

            $model->fk_pro_proveedores = $proveedor[0]->proveedor_id;
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];

            $model->save();

            $sqlSentencia = "delete from tb_com_compras_productos where fk_com_compras = ".$compra_id.";";
            $cnxConexion = Yii::$app->db;
            $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
            $eliminacion = $stmtSentencia->queryAll();

            foreach ($this->request->post()['productos'] as $key => $value)
            {
                $compraProducto = new ComprasProductos();
                $compraProducto->fk_com_compras = $model->compra_id;
                $compraProducto->fk_pro_productos = $value['producto_'.$key];
                $compraProducto->comprod_cantidad = $value['cantidad_'.$key];
                $compraProducto->comprod_vlr_unitario = $value['vlr_unit_'.$key];
                $compraProducto->comprod_vlr_total = $value['vlr_total_'.$key];
                $compraProducto->comprod_dcto = $value['dcto_'.$key];
                $compraProducto->comprod_vlr_final = $value['vlr_final_'.$key];
                $compraProducto->comprod_entregado = 0;
                $compraProducto->fc = date('Y-m-d H:i:s');
                $compraProducto->uc = $_SESSION['usuario_sesion']['usuarios_id'];

                $compraProducto->save();
            }
            
            return $this->redirect(['view', 'compra_id' => $model->compra_id]);
        }

        $sqlSentencia = "select cp.*, pr.producto_nombre
            from tb_com_compras_productos cp
            join tb_pro_productos pr on (cp.fk_pro_productos = pr.producto_id)
            where cp.fk_com_compras = ".$compra_id.";";

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $compraProductos = $stmtSentencia->queryAll();

        return $this->render($this->strRuta.'update', [
            'model' => $model,
            'compraProductos' => $compraProductos,
        ]);
    }

    /**
     * Deletes an existing Compras model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $compra_id Compra ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($compra_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($compra_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Compras model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $compra_id Compra ID
     * @return Compras the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($compra_id)
    {
        if (($model = Compras::findOne(['compra_id' => $compra_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionEnviarCompra($compra_id)
    {
        $compra = Compras::find()->where(['compra_id'=>$compra_id])->all()[0];

        $compra->fk_com_estados_compra = 2; // Estado de la compra: 2 - Enviado al proveedor
        $compra->fm = date('Y-m-d H:i:s');
        $compra->um = $_SESSION['usuario_sesion']['usuarios_id'];

        // Consultar proveedor
        $proveedor = Proveedores::findOne(['proveedor_id' => $compra->fk_pro_proveedores]);

        $compra->save();

        Yii::$app->mailer->compose()
            ->setFrom('info@upvendor.com')
            ->setTo($proveedor->proveedor_correo)
            ->setSubject('UPVENDOR - Orden de Compra #'.$compra->compra_id)
            ->setHtmlBody('<b>Se recibió una nueva orden de compra</b>')
            ->send();

        return $this->redirect(['view', 'compra_id' => $compra->compra_id]);
    }
}
