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

        // Consulta de ventas en los últimos 5 días
        $sqlVentas = "SELECT DATE(venta_fecha_venta) AS dia, COUNT(*) AS total_ventas
                      FROM tb_ven_ventas
                      WHERE venta_fecha_venta >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)
                      GROUP BY DATE(venta_fecha_venta)
                      ORDER BY venta_fecha_venta ASC";
        
        $conexion = Yii::$app->db;
        $comando = $conexion->createCommand($sqlVentas);
        $ventasUltimos5Dias = $comando->queryAll();

        // Consulta de compras en los últimos 5 días
        $sqlCompras = "SELECT DATE(compra_fecha_compra) AS dia, COUNT(*) AS total_compras
                      FROM tb_com_compras
                      WHERE compra_fecha_compra >= DATE_SUB(CURDATE(), INTERVAL 4 DAY)
                      GROUP BY DATE(compra_fecha_compra)
                      ORDER BY compra_fecha_compra ASC";

        $comando = $conexion->createCommand($sqlCompras);
        $comprasUltimos5Dias = $comando->queryAll();

        // Consulta de los clientes que más han comprado en el último mes
        $sqlClientes = "SELECT c.cliente_id, c.cliente_nombre_completo, COUNT(*) AS total_compras
                        FROM tb_ven_ventas v
                        JOIN tb_cli_cliente c ON v.fk_cli_cliente = c.cliente_id
                        WHERE v.venta_fecha_venta >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                        GROUP BY c.cliente_id
                        ORDER BY total_compras DESC
                        LIMIT 5";

        $comando = $conexion->createCommand($sqlClientes);
        $clientesMasCompras = $comando->queryAll();

        // Consulta los productos más vendidos del último mes
        $sqlProductos = "SELECT p.producto_id, p.producto_nombre, COUNT(*) AS total_ventas
                        FROM tb_ven_ventas v
                        JOIN tb_ven_ventas_productos vp ON v.venta_id = vp.fk_ven_ventas
                        JOIN tb_pro_productos p ON vp.fk_pro_productos = p.producto_id
                        WHERE v.venta_fecha_venta >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
                        GROUP BY p.producto_id
                        ORDER BY total_ventas DESC
                        LIMIT 5";
                    
        $comando = $conexion->createCommand($sqlProductos);
        $productosMasVendidos = $comando->queryAll();

        // Consulta los productos que están próximos a agotarse
        $sqlProductosVencidos = "SELECT p.producto_id, p.producto_nombre, p.producto_stock
                                FROM tb_pro_productos p
                                WHERE p.producto_stock <= 10
                                ORDER BY p.producto_stock ASC";

        $comando = $conexion->createCommand($sqlProductosVencidos);
        $productosVencidos = $comando->queryAll();


        // Pasar los datos a la vista
        return $this->render('reportes/dashboard', [
            'ventasUltimos5Dias' => $ventasUltimos5Dias,
            'comprasUltimos5Dias' => $comprasUltimos5Dias,
            'clientesMasCompras' => $clientesMasCompras,
            'productosMasVendidos' => $productosMasVendidos,
            'productosVencidos' => $productosVencidos,
        ]);
    }
}
