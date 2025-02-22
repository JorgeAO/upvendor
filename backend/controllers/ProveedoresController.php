<?php

namespace backend\controllers;

use app\models\Proveedores;
use app\models\ProveedoresSearch;
use stdClass;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProveedoresController extends Controller
{
    private $strRuta = "/productos/proveedores/";
    private $intOpcion = 4003;
    
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

        $searchModel = new ProveedoresSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($proveedor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        // Consultar las últimas 5 compras al proveedor de manera descendente
        $ultimasCompras = \app\models\Compras::find()
            ->where(['fk_pro_proveedores' => $proveedor_id])
            ->orderBy(['compra_fecha_compra' => SORT_DESC])
            ->limit(5)
            ->all();

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($proveedor_id),
            'ultimasCompras' => $ultimasCompras,
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Proveedores();

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
                if ($model->proveedor_nombre == '' || $model->proveedor_apellido == '') 
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
            if ($model->fk_par_tipo_persona == 2 && $model->proveedor_razonsocial == '') 
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

            if ($model->proveedor_ttodatos == 0)
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

            if ($model->fk_par_tipo_persona == 1) 
            {
                $model->proveedor_nombrecompleto = $model->proveedor_nombre.' '.$model->proveedor_apellido;
                $model->proveedor_razonsocial = '';
            }
            if ($model->fk_par_tipo_persona == 2) 
            {
                $model->proveedor_nombrecompleto = $model->proveedor_razonsocial;
                $model->proveedor_nombre = '';
                $model->proveedor_apellido = '';
                $model->proveedor_fnacimiento = '';
            }

            $model->proveedor_direccion = mb_strtoupper($model->proveedor_direccion);
            $model->proveedor_barrio = mb_strtoupper($model->proveedor_barrio);
            $model->proveedor_fttodatos = date('Y-m-d H:i:s');
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

            if ($model->save()) {
                return $this->redirect(['view', 'proveedor_id' => $model->proveedor_id]);
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

    public function actionUpdate($proveedor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($proveedor_id);

        if ($this->request->isPost && $model->load($this->request->post()))
        {
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
                if ($model->proveedor_nombre == '' || $model->proveedor_apellido == '') 
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
            if ($model->fk_par_tipo_persona == 2 && $model->proveedor_razonsocial == '') 
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

            if ($model->fk_par_tipo_persona == 1) 
            {
                $model->proveedor_primer_nombre = mb_strtoupper($model->proveedor_nombre);
                $model->proveedor_segundo_nombre = mb_strtoupper($model->proveedor_nombre);
                $model->proveedor_primer_apellido = mb_strtoupper($model->proveedor_apellido);
                $model->proveedor_segundo_apellido = mb_strtoupper($model->proveedor_apellido);

                $model->proveedor_nombrecompleto = $model->proveedor_primer_nombre.' '.$model->proveedor_segundo_nombre.' '.$model->proveedor_primer_apellido.' '.$model->proveedor_segundo_apellido;
                
                // Si la fecha de nacimiento está definida, súmale 5 horas
                if (!empty($model->proveedor_fnacimiento)) {
                    $fechaNacimiento = new \DateTime($model->proveedor_fnacimiento);
                    $fechaNacimiento->add(new \DateInterval('PT5H'));
                    $model->proveedor_fnacimiento = $fechaNacimiento->format('Y-m-d H:i:s');
                }

                $model->proveedor_razonsocial = '';
            }
            if ($model->fk_par_tipo_persona == 2) 
            {
                $model->proveedor_razonsocial = mb_strtoupper($model->proveedor_razonsocial);
                $model->proveedor_nombrecompleto = $model->proveedor_razonsocial;

                $model->proveedor_primer_nombre = '';
                $model->proveedor_segundo_nombre = '';
                $model->proveedor_primer_apellido = '';
                $model->proveedor_segundo_apellido = '';
                $model->proveedor_fnacimiento = '';
            }

            if ($model->proveedor_ttodatos == 0)
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

            $model->proveedor_direccion = mb_strtoupper($model->proveedor_direccion);
            $model->proveedor_barrio = mb_strtoupper($model->proveedor_barrio);
            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'proveedor_id' => $model->proveedor_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($proveedor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($proveedor_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($proveedor_id)
    {
        if (($model = Proveedores::findOne(['proveedor_id' => $proveedor_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
