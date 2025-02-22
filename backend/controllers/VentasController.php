<?php

namespace backend\controllers;

use app\models\Cliente;
use app\models\Productos;
use app\models\Ventas;
use app\models\VentasProductos;
use app\models\VentasSearch;
use app\models\Caja;
use app\models\Movimientos;
use app\models\FormaPago;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Vendedores;
class VentasController extends Controller
{
    private $strRuta = "/ventas/ventas/";
    private $intOpcion = 6001;
    
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
    
    public function actionIndex()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $searchModel = new VentasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($venta_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlSentencia = "SELECT 
                vp.*,
                p.producto_nombre,
                p.producto_descripcion
            FROM tb_ven_ventas_productos vp
            JOIN tb_pro_productos p ON (p.producto_id = vp.fk_pro_productos)
            WHERE vp.fk_ven_ventas = " . $venta_id;

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $productos = $stmtSentencia->queryAll();

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($venta_id),
            'productos' => $productos,
        ]);
    }
    
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Ventas();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $post = $this->request->post();

            // Obtener el cliente
            $identificacionCliente = explode(' - ', $post['Ventas']['fk_cli_cliente'])[0];
            $cliente = Cliente::find()->where(['cliente_identificacion' => $identificacionCliente])->all();

            // Obtener el vendedor
            $identificacionVendedor = explode(' - ', $post['Ventas']['fk_ven_vendedor'])[0];
            $vendedor = Vendedores::find()->where(['vendedor_identificacion' => $identificacionVendedor])->all();

            $model->fk_par_forma_pago = $post['Ventas']['fk_par_forma_pago'];
            $model->fk_cli_cliente = $cliente[0]->cliente_id;
            $model->fk_ven_vendedor = $vendedor[0]->vendedor_id;
            $model->fk_ven_estado_venta = 1;
            $model->venta_fecha_venta = date('Y-m-d H:i:s');
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

            $model->save();

            $totalVenta = 0;

            foreach ($this->request->post()['productos'] as $key => $value)
            {
                $ventaProducto = new VentasProductos();
                $ventaProducto->fk_ven_ventas = $model->venta_id;
                $ventaProducto->fk_pro_productos = $value['producto_'.$key];
                $ventaProducto->ventprod_cantidad = $value['cantidad_'.$key];
                $ventaProducto->ventprod_vlr_unitario = $value['vlr_unit_'.$key];
                $ventaProducto->ventprod_vlr_total = $value['vlr_total_'.$key];
                $ventaProducto->ventprod_dcto = $value['dcto_'.$key];
                $ventaProducto->ventprod_vlr_final = $value['vlr_final_'.$key]; 
                $ventaProducto->fc = date('Y-m-d H:i:s');
                $ventaProducto->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                $ventaProducto->save();

                // Consultar información del producto
                $producto = Productos::findOne(["producto_id" => $value['producto_'.$key]]);

                // Actualizar el stock del producto
                $stockActual = $producto->producto_stock;
                $cantidadVenta = $value['cantidad_'.$key];

                $producto->producto_stock = $stockActual - $cantidadVenta;
                $producto->save();

                $totalVenta += $value['vlr_final_'.$key];
            }

            // Consultar la forma de pago
            $formaPago = FormaPago::findOne($post['Ventas']['fk_par_forma_pago']);

            // Registrar el movimiento
            $movimiento = new Movimientos();
            $movimiento->movimiento_fecha = date('Y-m-d H:i:s');
            $movimiento->movimiento_observacion = 'Venta #'. $model->venta_id;
            $movimiento->fk_caj_tipo_movimiento = 3;
            $movimiento->fk_caj_cajas = $formaPago->fk_caj_cajas;
            $movimiento->movimiento_monto = $totalVenta;
            $movimiento->fc = date('Y-m-d H:i:s');
            $movimiento->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

            $movimiento->save();

            // Actualizar la caja
            $caja = Caja::findOne($formaPago->fk_caj_cajas);
            $caja->caja_monto = $caja->caja_monto + $totalVenta;
            $caja->save();

            return $this->redirect(['view', 'venta_id' => $model->venta_id]);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($venta_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($venta_id);

        if ($this->request->isPost && $model->load($this->request->post())){
            $post = $this->request->post();
            
            // Obtener el cliente
            $identificacion = explode(' - ', $post['Ventas']['fk_cli_cliente'])[0];
            $cliente = Cliente::find()->where(['cliente_identificacion' => $identificacion])->all();

            $model->fk_cli_cliente = $cliente[0]->cliente_id;

            foreach ($this->request->post()['productos'] as $key => $value)
            {
                $producto = Productos::findOne($value['producto_'.$key]);

                if ($producto->fk_pro_categoria == 1){
                    $ventaProductoAnterior = VentasProductos::findOne($producto->producto_id);

                    $stockActual = $producto->producto_stock;
                    $stockVentaAnterior = $ventaProductoAnterior->ventprod_cantidad;
                    $stockAntesDeVenta = $stockActual + $stockVentaAnterior;

                    $producto->producto_stock = $stockAntesDeVenta;
                    $producto->save();
                }

                $ventaProducto = VentasProductos::findOne($producto->producto_id);
                $ventaProducto->fk_pro_productos = $value['producto_'.$key];
                $ventaProducto->ventprod_cantidad = $value['cantidad_'.$key];
                $ventaProducto->ventprod_vlr_unitario = $value['vlr_unit_'.$key];
                $ventaProducto->ventprod_vlr_total = $value['vlr_total_'.$key];
                $ventaProducto->ventprod_dcto = $value['dcto_'.$key];
                $ventaProducto->ventprod_vlr_final = $value['vlr_final_'.$key];

                if  ($producto->fk_pro_categoria == 1){
                    $stockActual = $producto->producto_stock;
                    $cantidadVenta = $value['cantidad_'.$key];
                    $producto->producto_stock = $stockActual + $cantidadVenta;
                    $producto->save();
                }
                
                $ventaProducto->save();
            }

            $model->save();

            return $this->redirect(['view', 'venta_id' => $model->venta_id]);
        }

        $sqlSentencia = "SELECT 
                vp.*,
                p.producto_nombre,
                p.producto_descripcion
            FROM tb_ven_ventas_productos vp
            JOIN tb_pro_productos p ON (p.producto_id = vp.fk_pro_productos)
            WHERE vp.fk_ven_ventas = " . $venta_id;

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $productos = $stmtSentencia->queryAll();

        return $this->render($this->strRuta.'update', [
            'model' => $model,
            'productos' => $productos,
        ]);
    }
    
    public function actionDelete($venta_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($venta_id)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($venta_id)
    {
        if (($model = Ventas::findOne(['venta_id' => $venta_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
