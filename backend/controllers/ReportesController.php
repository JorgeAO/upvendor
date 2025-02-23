<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class ReportesController extends Controller
{
    private $strRuta = "/reportes/reportes/";

    public function actionDashboard()
    {
        $rta = PermisosController::validarPermiso(7001, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new \stdClass();
        $model->fecha_inicial = '';
        $model->fecha_final = '';

        if ($this->request->isPost) 
        {
            $post = $this->request->post();
            $model = (object) $this->request->post();

            if (empty($model->fecha_inicial) || empty($model->fecha_final)) {
                $rta = [
                    "error" => true,
                    "mensaje" => "La fecha inicial y la fecha final son requeridas"
                ];

                return $this->render($this->strRuta.'dashboard', [
                    'model' => $model,
                    'data' => $rta,
                    'totalVentas' => 0,
                    'totalCompras' => 0,
                    'clientesMasCompras' => [],
                    'productosMasVendidos' => [],
                    'productosVencidos' => [],
                    'cajas' => [],
                ]);
            }

            $conexion = Yii::$app->db;

            //-----------------------------------------------------------------------------//
            // TOTAL VENTAS
            //-----------------------------------------------------------------------------//
            $totalVentas = $this->consultarVentas([
                'fecha_inicial' => $model->fecha_inicial,
                'fecha_final' => $model->fecha_final
            ]);
            //-----------------------------------------------------------------------------//

            //-----------------------------------------------------------------------------//
            // TOTAL COMPRAS
            //-----------------------------------------------------------------------------//
            $totalCompras = $this->consultarCompras([
                'fecha_inicial' => $model->fecha_inicial,
                'fecha_final' => $model->fecha_final
            ]);
            //-----------------------------------------------------------------------------//

            //-----------------------------------------------------------------------------//
            // CLIENTES QUE MÁS HAN COMPRADO
            //-----------------------------------------------------------------------------//
            $clientesMasCompras = $this->consultarClientesMasCompras([
                'fecha_inicial' => $model->fecha_inicial,
                'fecha_final' => $model->fecha_final
            ]);
            //-----------------------------------------------------------------------------//

            //-----------------------------------------------------------------------------//
            // PRODUCTOS MÁS VENDIDOS
            //-----------------------------------------------------------------------------//
            $productosMasVendidos = $this->consultarProductosMasVendidos([
                'fecha_inicial' => $model->fecha_inicial,
                'fecha_final' => $model->fecha_final
            ]);
            //-----------------------------------------------------------------------------//

            //-----------------------------------------------------------------------------//
            // CAJAS
            //-----------------------------------------------------------------------------//
            $cajas = $this->consultarCajas();
            //-----------------------------------------------------------------------------//
    
            // Pasar los datos a la vista
            return $this->render('reportes/dashboard', [
                'model' => $model,
                'data' => $rta,
                'totalVentas' => $totalVentas,
                'totalCompras' => $totalCompras,
                'clientesMasCompras' => $clientesMasCompras,
                'productosMasVendidos' => $productosMasVendidos,
                'productosVencidos' => [],
                'cajas' => $cajas,
            ]);
        }

        return $this->render($this->strRuta.'dashboard', [
            'model' => $model,
            'data' => $rta,
            'totalVentas' => 0,
            'totalCompras' => 0,
            'clientesMasCompras' => [],
            'productosMasVendidos' => [],
            'productosVencidos' => [],
            'cajas' => [],
        ]);
    }

    // Método para consultar el total de las ventas
    public function consultarVentas($parametros)
    {
        $rta = PermisosController::validarPermiso(7001, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlVentas = "SELECT sum(ventprod_vlr_final) AS total_ventas
            FROM tb_ven_ventas
            join tb_ven_ventas_productos on ( fk_ven_ventas = venta_id )
            WHERE venta_fecha_venta BETWEEN :fecha_inicial AND :fecha_final";
        
        $conexion = Yii::$app->db;
        $comando = $conexion->createCommand($sqlVentas);
        $comando->bindParam(':fecha_inicial', $parametros['fecha_inicial']);
        $comando->bindParam(':fecha_final', $parametros['fecha_final']);
        $totalVentas = $comando->queryAll()[0]['total_ventas'];

        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $totalVentas;
    }

    // Método para consultar el total de las compras
    public function consultarCompras($parametros)
    {
        $rta = PermisosController::validarPermiso(7001, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlCompras = "SELECT sum(comprod_vlr_final) AS total_compras
                      FROM tb_com_compras
                      JOIN tb_com_compras_productos ON (fk_com_compras = compra_id)
                      WHERE compra_fecha_compra BETWEEN :fecha_inicial AND :fecha_final";

        $conexion = Yii::$app->db;
        $comando = $conexion->createCommand($sqlCompras);
        $comando->bindParam(':fecha_inicial', $parametros['fecha_inicial']);
        $comando->bindParam(':fecha_final', $parametros['fecha_final']);
        $totalCompras = $comando->queryAll()[0]['total_compras'];

        return $totalCompras;
    }

    // Método para consultar los clientes que más han comprado
    public function consultarClientesMasCompras($parametros)
    {
        $rta = PermisosController::validarPermiso(7001, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlClientes = "SELECT c.cliente_id, c.cliente_nombre_completo, COUNT(*) AS total_compras
                        FROM tb_ven_ventas v
                        JOIN tb_cli_cliente c ON v.fk_cli_cliente = c.cliente_id
                        WHERE v.venta_fecha_venta BETWEEN :fecha_inicial AND :fecha_final
                        GROUP BY c.cliente_id
                        ORDER BY total_compras DESC
                        LIMIT 5";

        $conexion = Yii::$app->db;
        $comando = $conexion->createCommand($sqlClientes);
        $comando->bindParam(':fecha_inicial', $parametros['fecha_inicial']);
        $comando->bindParam(':fecha_final', $parametros['fecha_final']);
        $clientesMasCompras = $comando->queryAll();

        return $clientesMasCompras;
    }

    // Método para consultar los productos más vendidos
    public function consultarProductosMasVendidos($parametros)
    {
        $rta = PermisosController::validarPermiso(7001, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlProductos = "SELECT p.producto_id, p.producto_nombre, COUNT(*) AS total_ventas
                        FROM tb_ven_ventas v
                        JOIN tb_ven_ventas_productos vp ON v.venta_id = vp.fk_ven_ventas
                        JOIN tb_pro_productos p ON vp.fk_pro_productos = p.producto_id
                        WHERE v.venta_fecha_venta BETWEEN :fecha_inicial AND :fecha_final
                        and p.fk_pro_categoria = 1 /* exclusivo para la categoría PRODUCTO */
                        GROUP BY p.producto_id
                        ORDER BY total_ventas DESC
                        LIMIT 5";
        
        $conexion = Yii::$app->db;
        $comando = $conexion->createCommand($sqlProductos);
        $comando->bindParam(':fecha_inicial', $parametros['fecha_inicial']);
        $comando->bindParam(':fecha_final', $parametros['fecha_final']);
        $productosMasVendidos = $comando->queryAll();

        return $productosMasVendidos;
    }

    // Método para consultar cuánto dinero tienen las cajas
    public function consultarCajas()
    {
        $rta = PermisosController::validarPermiso(7001, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $sqlCajas = "SELECT caja_id, caja_descripcion, caja_monto
                    FROM tb_caj_cajas
                    WHERE caja_monto > 0";

        $conexion = Yii::$app->db;
        $comando = $conexion->createCommand($sqlCajas);
        $cajas = $comando->queryAll();

        return $cajas;
    }
}
