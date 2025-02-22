<?php

namespace backend\controllers;

use app\models\Caja;
use app\models\Compras;
use app\models\ComprasProductos;
use app\models\ComprasSearch;
use app\models\FormaPago;
use app\models\Movimientos;
use app\models\Productos;
use app\models\Proveedores;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use stdClass;

class ComprasController extends Controller
{
    private $strRuta = "/compras/compras/";
    private $intOpcion = 5001;
    
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

        $searchModel = new ComprasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($compra_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlSentencia = "select 
                cp.*,
                p.producto_nombre,
                p.producto_descripcion
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
    
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Compras();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $transaction = Yii::$app->db->beginTransaction();
            $productosComprados = [];

            try {
                $proveedorIdentificacion = explode(' - ', $model->fk_pro_proveedores)[0];
                $proveedor = Proveedores::find()->select('proveedor_id')->where(['proveedor_identificacion' => $proveedorIdentificacion])->all();

                $valorTotal = 0;

                foreach ($this->request->post()['productos'] as $key => $value) {
                    $valorTotal += $value['vlr_total_'.$key];

                    $productoComprado = [];
                    $productoComprado['fk_pro_productos'] = $value['producto_'.$key];
                    $productoComprado['comprod_cantidad'] = $value['cantidad_'.$key];
                    $productoComprado['comprod_vlr_unitario'] = $value['vlr_unit_'.$key];
                    $productoComprado['comprod_dcto'] = $value['dcto_'.$key];
                    $productoComprado['valor_total'] = $value['vlr_total_'.$key];
                    $productoComprado['valor_final'] = $value['vlr_final_'.$key];
                    
                    array_push($productosComprados, $productoComprado);
                }

                //  Obtener información de la forma de pago
                $formaPago = FormaPago::find()->where(['formpago_id' => $model->fk_par_forma_pago])->one();

                // Obtener información de la caja
                $caja = Caja::find()->where(['caja_id' => $formaPago->fk_caj_cajas])->one();

                // Validar si la cja tiene saldo suficiente para la compra
                if ($caja->caja_monto < $valorTotal) {
                    throw new \Exception('La caja '.$caja->caja_descripcion.' no tiene saldo suficiente para la compra. El saldo disponible es: '.$caja->caja_monto);
                }

                $productos = Productos::find()->where(['producto_id' => $productosComprados])->all();
                foreach ($productos as $key => $value) {
                    if ($value->producto_stock < $value['cantidad_'.$key]) {
                        throw new \Exception('El stock del producto '.$value->producto_nombre.' es insuficiente.');
                    }
                }

                $model->fk_pro_proveedores = $proveedor[0]->proveedor_id;
                $model->fk_com_estados_compra = 1; // 1 - Confirmada
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                if (!$model->save()){
                    throw new \Exception('Error al guardar la compra.');
                }

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
                    $compraProducto->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                    // Consultar información del producto
                    $producto = Productos::findOne(["producto_id" => $value['producto_'.$key]]);

                    // Recalcular el precio de venta
                    // Calcular el nuevo precio de compra promedio
                    $stockActual = $producto->producto_stock;
                    $precioCompraActual = $producto->producto_preciocompra;
                    $cantidadNueva = $value['cantidad_'.$key];
                    $precioCompraNuevo = $value['vlr_final_'.$key] / $value['cantidad_'.$key];

                    $totalValorActual = $stockActual * $precioCompraActual;

                    $nuevoStock = $stockActual + $cantidadNueva;
                    $nuevoPrecioCompraPromedio = round(($totalValorActual + $value['vlr_final_'.$key]) / $nuevoStock, 0);
                    
                    $producto->producto_preciocompra = $nuevoPrecioCompraPromedio;
                    $producto->producto_stock = $nuevoStock; 

                    if (!$producto->save()) {
                        throw new \Exception('Error al actualizar el producto '.$producto->producto_descripcion.'.');
                    }

                    if (!$compraProducto->save()){
                        throw new \Exception('Error al guardar el producto '.$producto->producto_descripcion.' en la compra.');
                    }
                }

                // Afectar la caja
                $caja->caja_monto = $caja->caja_monto - $valorTotal;
                if (!$caja->save()){
                    throw new \Exception('Error al actualizar el saldo de la caja.');   
                }

                // Registrar el movimiento de la caja
                $movimientoCaja = new Movimientos();
                $movimientoCaja->movimiento_observacion = 'Compra #'.$model->compra_id;
                $movimientoCaja->movimiento_fecha = date('Y-m-d H:i:s');
                $movimientoCaja->fk_caj_tipo_movimiento = 4; // 4 - Compra
                $movimientoCaja->fk_caj_cajas = $caja->caja_id;
                $movimientoCaja->movimiento_monto = $valorTotal;
                $movimientoCaja->fc = date('Y-m-d H:i:s');
                $movimientoCaja->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                if (!$movimientoCaja->save()){
                    throw new \Exception('Error al guardar el movimiento de la caja.');
                }

                $transaction->commit();

                return $this->redirect(['view', 'compra_id' => $model->compra_id]);
            } catch (\Exception $e) {
                $transaction->rollBack();

                return $this->render($this->strRuta.'create', [
                    'model' => $model,
                    'compraProductos' => $productosComprados,
                    'data' => [
                        'error' => true,
                        'mensaje' => $e->getMessage(),
                    ]
                ]);
            }
        } 
        else 
        {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
            'compraProductos' => [],
            'data' => [
                'error' => false,
                'message' => '',
            ]
        ]);
    }
    
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
            $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];

            $model->save();

            // Consultar los productos que se adquirieron en la compra
            $compraProducto = ComprasProductos::find()->where(['fk_com_compras' => $compra_id])->all();

            // Recorrer los productos
            foreach ($compraProducto as $key => $value) {
                // Consultar información del producto
                $producto = Productos::findOne(['producto_id' => $value->fk_pro_productos]);

                $stockActual = $producto->producto_stock;
                $stockCompra = $value->comprod_cantidad;
                $stockAnterior = $stockActual - $stockCompra;

                $totalActual = $stockActual * $producto->producto_preciocompra;
                $totalCompra = $value->comprod_vlr_final;
                $totalAnterior = $totalActual - $totalCompra;

                $precioCompraAnterior = $totalAnterior / $stockAnterior;

                // Establecer nuevos valores
                $producto->producto_preciocompra = $precioCompraAnterior;
                $producto->producto_stock = $stockAnterior;

                // Guardar los cambios
                $producto->save();
            }

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
                $compraProducto->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                // Consultar información del producto
                $producto = Productos::findOne(["producto_id" => $value['producto_'.$key]]);

                $stockActual = $producto->producto_stock;
                $precioCompraActual = $producto->producto_preciocompra;
                $cantidadNueva = $value['cantidad_'.$key];
                $precioCompraNuevo = $value['vlr_final_'.$key] / $value['cantidad_'.$key];

                $totalValorActual = $stockActual * $precioCompraActual;

                $nuevoStock = $stockActual + $cantidadNueva;
                $nuevoPrecioCompraPromedio = round(($totalValorActual + $value['vlr_final_'.$key]) / $nuevoStock, 0);
                
                $producto->producto_preciocompra = $nuevoPrecioCompraPromedio;
                $producto->producto_stock = $nuevoStock; 

                $producto->save();

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

    public function actionDelete($compra_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        // Consultar los productos que se adquirieron en la compra
        $compraProducto = ComprasProductos::find()->where(['fk_com_compras' => $compra_id])->all();

        // Recorrer los productos
        foreach ($compraProducto as $key => $value) {
            // Consultar información del producto
            $producto = Productos::findOne(['producto_id' => $value->fk_pro_productos]);

            $stockActual = $producto->producto_stock;
            $stockCompra = $value->comprod_cantidad;
            $stockAnterior = $stockActual - $stockCompra;

            $totalActual = $stockActual * $producto->producto_preciocompra;
            $totalCompra = $value->comprod_vlr_final;
            $totalAnterior = $totalActual - $totalCompra;

            $precioCompraAnterior = $totalAnterior / $stockAnterior;

            // Establecer nuevos valores
            $producto->producto_preciocompra = $precioCompraAnterior;
            $producto->producto_stock = $stockAnterior;

            // Guardar los cambios
            $producto->save();
        }

        // Buscar el modelo de compra
        $model = $this->findModel($compra_id);
        
        // Cambiar el estado a 2 en lugar de eliminar
        $model->fk_com_estados_compra = 2;
        
        // Actualizar la fecha de modificación y el usuario que modifica
        $model->fm = date('Y-m-d H:i:s');
        $model->um = Yii::$app->user->id;

        $model->save();

        return $this->redirect(['view', 'compra_id' => $model->compra_id]);
    }

    protected function findModel($compra_id)
    {
        if (($model = Compras::findOne(['compra_id' => $compra_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
