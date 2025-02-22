<?php

namespace backend\controllers;

use app\models\Cliente;
use app\models\ClienteSearch;
use app\models\Ventas;
use stdClass;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ClienteController extends Controller
{
    private $strRuta = "/clientes/cliente/";
    private $intOpcion = 3001;

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

        $searchModel = new ClienteSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($cliente_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        // Consultar las últimas 5 compras del cliente ordenadas de la más reciente a la más antigua
        $ventas = Ventas::find()->where(['fk_cli_cliente' => $cliente_id])->orderBy(['venta_id' => SORT_DESC])->limit(5)->all();

        // Consultar los 5 productos más vendidos por este cliente
        $sqlProducto = "select p.producto_id, p.producto_descripcion, count(1) as cantidad
            from tb_ven_ventas v
            join tb_ven_ventas_productos vp on ( v.venta_id = vp.fk_ven_ventas )
            join tb_pro_productos p on ( vp.fk_pro_productos = p.producto_id )
            where v.fk_cli_cliente = ".$cliente_id."
            group by p.producto_id, p.producto_descripcion
            order by 3 desc;";

        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlProducto);
        $productos = $stmtSentencia->queryAll();


        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($cliente_id),
            'ventas' => $ventas,
            'productos' => $productos,
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Cliente();

        if ($this->request->isPost) 
        {
            $model->load($this->request->post());

            $data = new stdClass;

            // Validar coherencia entre tipo de persona y tipo de identificación
            // Una persona natural no debe tener NIT
            if ($model->fk_par_tipo_persona == 1 && $model->fk_par_tipo_identificacion == 2)
            {
                return $this->render(
                    $this->strRuta.'create', 
                    [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => 'Una persona natural no debe tener NIT',
                        ],
                    ]
                );
            }

            // Validar, si es persona natural que tenga nombre y apellido
            if ($model->fk_par_tipo_persona == 1)
            {
                if ($model->cliente_primer_nombre == '' || $model->cliente_primer_apellido == '') 
                {
                    return $this->render(
                        $this->strRuta.'create', 
                        [
                            'model' => $model,
                            'data' => [
                                "error" => true,
                                "mensaje" => 'Por favor indique nombre y apellido',
                            ],
                        ]
                    );
                }
            }

            // Validar coherencia entre tipo de persona y tipo de identificación
            // Una persona jurídica no debe tener cédula de ciudadanía
            if ($model->fk_par_tipo_persona == 2 && $model->fk_par_tipo_identificacion == 1)
            {
                return $this->render(
                    $this->strRuta.'create', 
                    [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => 'Una persona jurídica no debe tener cédula de ciudadanía',
                        ],
                    ]
                );
            }

            // Validar, si es persona jurídica que tenga razón social
            if ($model->fk_par_tipo_persona == 2 && $model->cliente_razonsocial == '') 
            {
                return $this->render(
                    $this->strRuta.'create', 
                    [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => 'Por favor indique la razón social',
                        ],
                    ]
                );
            }

            // Si es persona natural, no debe tener razón social
            if ($model->fk_par_tipo_persona == 1) {
                $model->cliente_razonsocial = '';
                
                $model->cliente_primer_nombre = mb_strtoupper($model->cliente_primer_nombre);
                $model->cliente_segundo_nombre = mb_strtoupper($model->cliente_segundo_nombre);
                $model->cliente_primer_apellido = mb_strtoupper($model->cliente_primer_apellido);
                $model->cliente_segundo_apellido = mb_strtoupper($model->cliente_segundo_apellido);

                $model->cliente_nombre_completo = 
                    $model->cliente_primer_nombre . ' ' . 
                    $model->cliente_segundo_nombre . ' ' . 
                    $model->cliente_primer_apellido . ' ' . 
                    $model->cliente_segundo_apellido;
                
                    // Si la fecha de nacimiento está definida, súmale 5 horas
                if (!empty($model->cliente_fnacimiento)) {
                    $fechaNacimiento = new \DateTime($model->cliente_fnacimiento);
                    $fechaNacimiento->add(new \DateInterval('PT5H'));
                    $model->cliente_fnacimiento = $fechaNacimiento->format('Y-m-d H:i:s');
                }
            }

            // Si es persona jurídica, no debe tener nombre y apellido
            if ($model->fk_par_tipo_persona == 2) {
                $model->cliente_primer_nombre = '';
                $model->cliente_segundo_nombre = '';
                $model->cliente_primer_apellido = '';
                $model->cliente_segundo_apellido = '';
                $model->cliente_fnacimiento = '';
                
                $model->cliente_razonsocial = mb_strtoupper($model->cliente_razonsocial);

                $model->cliente_nombre_completo = $model->cliente_razonsocial;
            }

            if ($model->cliente_ttodatos == 0)
            {
                return $this->render(
                    $this->strRuta.'create', 
                    [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => 'Debe aceptar las políticas de tratamiento de información personal',
                        ],
                    ]
                );
            }
            
            $model->cliente_direccion = mb_strtoupper($model->cliente_direccion);
            $model->cliente_barrio = mb_strtoupper($model->cliente_barrio);
            $model->cliente_fttodatos = date('Y-m-d H:i:s');
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

            if ($model->save()) {
                return $this->redirect(['view', 'cliente_id' => $model->cliente_id]);
            }
        } 
        else 
        {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($cliente_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($cliente_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $data = new stdClass;

            // Validar coherencia entre tipo de persona y tipo de identificación
            // Una persona natural no debe tener NIT
            if ($model->fk_par_tipo_persona == 1 && $model->fk_par_tipo_identificacion == 2)
            {
                return $this->render(
                    $this->strRuta.'update', 
                    [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => 'Una persona natural no debe tener NIT',
                        ],
                    ]
                );
            }

            // Validar, si es persona natural que tenga nombre y apellido
            if ($model->fk_par_tipo_persona == 1)
            {
                if ($model->cliente_primer_nombre == '' || $model->cliente_primer_apellido == '') 
                {
                    return $this->render(
                        $this->strRuta.'update', 
                        [
                            'model' => $model,
                            'data' => [
                                "error" => true,
                                "mensaje" => 'Por favor indique nombre y apellido',
                            ],
                        ]
                    );
                }
            }

            // Validar coherencia entre tipo de persona y tipo de identificación
            // Una persona jurídica no debe tener cédula de ciudadanía
            if ($model->fk_par_tipo_persona == 2 && $model->fk_par_tipo_identificacion == 1)
            {
                return $this->render(
                    $this->strRuta.'update', 
                    [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => 'Una persona jurídica no debe tener cédula de ciudadanía',
                        ],
                    ]
                );
            }

            // Validar, si es persona jurídica que tenga razón social
            if ($model->fk_par_tipo_persona == 2 && $model->cliente_razonsocial == '') 
            {
                return $this->render(
                    $this->strRuta.'update', 
                    [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => 'Por favor indique la razón social',
                        ],
                    ]
                );
            }

            if ($model->fk_par_tipo_persona == 1) {
                $model->cliente_razonsocial = '';

                $model->cliente_primer_nombre = mb_strtoupper($model->cliente_primer_nombre);
                $model->cliente_segundo_nombre = mb_strtoupper($model->cliente_segundo_nombre);
                $model->cliente_primer_apellido = mb_strtoupper($model->cliente_primer_apellido);
                $model->cliente_segundo_apellido = mb_strtoupper($model->cliente_segundo_apellido);

                $model->cliente_nombre_completo = 
                    $model->cliente_primer_nombre . ' ' . 
                    $model->cliente_segundo_nombre . ' ' . 
                    $model->cliente_primer_apellido . ' ' . 
                    $model->cliente_segundo_apellido;
                
                // Si la fecha de nacimiento está definida, súmale 5 horas
                if (!empty($model->cliente_fnacimiento)) {
                    $fechaNacimiento = new \DateTime($model->cliente_fnacimiento);
                    $fechaNacimiento->add(new \DateInterval('PT5H'));
                    $model->cliente_fnacimiento = $fechaNacimiento->format('Y-m-d H:i:s');
                }
            }
            if ($model->fk_par_tipo_persona == 2) {
                $model->cliente_primer_nombre = '';
                $model->cliente_segundo_nombre = '';
                $model->cliente_primer_apellido = '';
                $model->cliente_segundo_apellido = '';
                $model->cliente_fnacimiento = '';

                $model->cliente_razonsocial = mb_strtoupper($model->cliente_razonsocial);

                $model->cliente_nombre_completo = $model->cliente_razonsocial;
            }

            if ($model->cliente_ttodatos == 0)
            {
                return $this->render(
                    $this->strRuta.'update', 
                    [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => 'Debe aceptar las políticas de tratamiento de información personal',
                        ],
                    ]
                );
            }
            
            $model->cliente_direccion = mb_strtoupper($model->cliente_direccion);
            $model->cliente_barrio = mb_strtoupper($model->cliente_barrio);
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'cliente_id' => $model->cliente_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($cliente_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($cliente_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($cliente_id)
    {
        if (($model = Cliente::findOne(['cliente_id' => $cliente_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
