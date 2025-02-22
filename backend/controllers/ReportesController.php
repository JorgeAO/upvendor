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
                ]);
            }

            // Consulta de ventas en el rango de fechas seleccionado
            $sqlVentas = "SELECT sum(ventprod_vlr_final) AS total_ventas
                FROM tb_ven_ventas
                join tb_ven_ventas_productos on ( fk_ven_ventas = venta_id )
                WHERE venta_fecha_venta BETWEEN :fecha_inicial AND :fecha_final";
            
            $conexion = Yii::$app->db;
            $comando = $conexion->createCommand($sqlVentas);
            $comando->bindParam(':fecha_inicial', $model->fecha_inicial);
            $comando->bindParam(':fecha_final', $model->fecha_final);
            $totalVentas = $comando->queryAll()[0]['total_ventas'];

            //-----------------------------------------------------------------------------//
    
            // Consulta de compras en el rango de fechas seleccionado
            $sqlCompras = "SELECT sum(comprod_vlr_final) AS total_compras
                          FROM tb_com_compras
                          JOIN tb_com_compras_productos ON (fk_com_compras = compra_id)
                          WHERE compra_fecha_compra BETWEEN :fecha_inicial AND :fecha_final";
    
            $comando = $conexion->createCommand($sqlCompras);
            $comando->bindParam(':fecha_inicial', $model->fecha_inicial);
            $comando->bindParam(':fecha_final', $model->fecha_final);
            $totalCompras = $comando->queryAll()[0]['total_compras'];

            //-----------------------------------------------------------------------------//
    
            // Consulta de los clientes que más han comprado en el rango de fechas seleccionado
            $sqlClientes = "SELECT c.cliente_id, c.cliente_nombre_completo, COUNT(*) AS total_compras
                            FROM tb_ven_ventas v
                            JOIN tb_cli_cliente c ON v.fk_cli_cliente = c.cliente_id
                            WHERE v.venta_fecha_venta BETWEEN :fecha_inicial AND :fecha_final
                            GROUP BY c.cliente_id
                            ORDER BY total_compras DESC
                            LIMIT 5";
    
            $comando = $conexion->createCommand($sqlClientes);
            $comando->bindParam(':fecha_inicial', $model->fecha_inicial);
            $comando->bindParam(':fecha_final', $model->fecha_final);
            $clientesMasCompras = $comando->queryAll();

            //-----------------------------------------------------------------------------//
    
            // Consulta los productos más vendidos en el rango de fechas seleccionado
            $sqlProductos = "SELECT p.producto_id, p.producto_nombre, COUNT(*) AS total_ventas
                            FROM tb_ven_ventas v
                            JOIN tb_ven_ventas_productos vp ON v.venta_id = vp.fk_ven_ventas
                            JOIN tb_pro_productos p ON vp.fk_pro_productos = p.producto_id
                            WHERE v.venta_fecha_venta BETWEEN :fecha_inicial AND :fecha_final
                            GROUP BY p.producto_id
                            ORDER BY total_ventas DESC
                            LIMIT 5";
                        
            $comando = $conexion->createCommand($sqlProductos);
            $comando->bindParam(':fecha_inicial', $model->fecha_inicial);
            $comando->bindParam(':fecha_final', $model->fecha_final);
            $productosMasVendidos = $comando->queryAll();

            //-----------------------------------------------------------------------------//
    
            // Pasar los datos a la vista
            return $this->render('reportes/dashboard', [
                'model' => $model,
                'data' => $rta,
                'totalVentas' => $totalVentas,
                'totalCompras' => $totalCompras,
                'clientesMasCompras' => $clientesMasCompras,
                'productosMasVendidos' => $productosMasVendidos,
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
        ]);
    }
}
