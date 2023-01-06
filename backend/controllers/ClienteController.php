<?php

namespace backend\controllers;

use app\models\Cliente;
use app\models\ClienteSearch;
use stdClass;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
{
    private $strRuta = "/clientes/cliente/";
    private $intOpcion = 3001;

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
     * Lists all Cliente models.
     *
     * @return string
     */
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

    /**
     * Displays a single Cliente model.
     * @param int $cliente_id Cliente ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cliente_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($cliente_id),
        ]);
    }

    /**
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
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
                if ($model->cliente_nombre == '' || $model->cliente_apellido == '') 
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

            if ($model->fk_par_tipo_persona == 1) 
            {
                $model->cliente_razonsocial = '';
            }
            if ($model->fk_par_tipo_persona == 2) 
            {
                $model->cliente_nombre = '';
                $model->cliente_apellido = '';
                $model->cliente_fnacimiento = '';
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

            $model->cliente_fttodatos = date('Y-m-d H:i:s');
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

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

    /**
     * Updates an existing Cliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $cliente_id Cliente ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
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
                if ($model->cliente_nombre == '' || $model->cliente_apellido == '') 
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

            if ($model->fk_par_tipo_persona == 1) 
            {
                $model->cliente_razonsocial = '';
            }
            if ($model->fk_par_tipo_persona == 2) 
            {
                $model->cliente_nombre = '';
                $model->cliente_apellido = '';
                $model->cliente_fnacimiento = '';
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

            $model->fm = date('Y-m-d H:i:s');
            $model->um = $_SESSION['usuario_sesion']['usuarios_id'];
            
            if ($model->save())
                return $this->redirect(['view', 'cliente_id' => $model->cliente_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cliente model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $cliente_id Cliente ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cliente_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($cliente_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $cliente_id Cliente ID
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cliente_id)
    {
        if (($model = Cliente::findOne(['cliente_id' => $cliente_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
