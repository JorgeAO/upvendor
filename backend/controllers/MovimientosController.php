<?php

namespace backend\controllers;

use app\models\Movimientos;
use app\models\MovimientosSearch;
use app\models\Caja;
use app\models\TipoMovimiento;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MovimientosController extends Controller
{
    private $strRuta = "/cajas/movimientos/";
    private $intOpcion = 8003;

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

        $searchModel = new MovimientosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render( $this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($movimiento_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render( $this->strRuta.'view', [
            'model' => $this->findModel($movimiento_id),
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Movimientos();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

                // Consultar el tipo de movimiento para obtener la operación
                $tipoMovimiento = TipoMovimiento::find()->where(['tipomovi_id' => $model->fk_caj_tipo_movimiento])->one();

                // Consultar la caja que se afecta
                $caja = Caja::find()->where(['caja_id' => $model->fk_caj_cajas])->one();

                // Validar que si el tipo de movimiento es - y el valor que se va a retirar es superior al disponible en la caja no se pueda grabar el movimiento
                if ($tipoMovimiento->tipomovi_operacion == '-' && $model->movimiento_monto > $caja->caja_monto) {
                    return $this->render($this->strRuta.'create', [
                        'model' => $model,
                        'data' => [
                            "error" => true,
                            "mensaje" => "El monto a retirar es superior al disponible en la caja",
                        ]
                    ]);
                }

                // Realizar la operación según el tipo de movimiento
                if ($tipoMovimiento->tipomovi_operacion == '+') {
                    $nuevoValor = $caja->caja_monto + $model->movimiento_monto;
                } else {
                    $nuevoValor = $caja->caja_monto - $model->movimiento_monto;
                }

                // Actualizar el monto de la caja
                $caja->caja_monto = $nuevoValor;
                $caja->save(); 

                if ($model->save()) {
                    return $this->redirect(['view', 'movimiento_id' => $model->movimiento_id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render( $this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($movimiento_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($movimiento_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'movimiento_id' => $model->movimiento_id]);
        }

        return $this->render( $this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($movimiento_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($movimiento_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($movimiento_id)
    {
        if (($model = Movimientos::findOne(['movimiento_id' => $movimiento_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionTrasladar()
    {
        $rta = PermisosController::validarPermiso(8004, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new \stdClass();
        $model->caja_origen = '';
        $model->caja_destino = '';
        $model->monto = '';

        if ($this->request->isPost) {
            $post = $this->request->post();

            $model = (object) $this->request->post();

            // Validar que se haya indicado la caja de origen
            if (empty($model->caja_origen)) {
                $rta = [
                    "error" => true,
                    "mensaje" => "La caja de origen es requerida"
                ];

                return $this->render($this->strRuta.'trasladar', [ 
                    'model' => $model,  
                    'data' => $rta
                ]);
            }

            // Validar que se haya indicado la caja de destino
            if (empty($model->caja_destino)) {
                $rta = [
                    "error" => true,
                    "mensaje" => "La caja de destino es requerida"
                ];

                return $this->render($this->strRuta.'trasladar', [ 
                    'model' => $model,
                    'data' => $rta
                ]);
            }

            // Validar que se haya indicado el monto
            if (empty($model->monto)) {
                $rta = [
                    "error" => true,
                    "mensaje" => "El monto es requerido"
                ];

                return $this->render($this->strRuta.'trasladar', [ 
                    'model' => $model,
                    'data' => $rta
                ]);
            }

            $cajaOrigen = Caja::find()->where(['caja_id' => $model->caja_origen])->one();
            $cajaDestino = Caja::find()->where(['caja_id' => $model->caja_destino])->one();

            if ($cajaOrigen->caja_monto < $model->monto) {
                $rta = [
                    "error" => true,
                    "mensaje" => "El monto a transferir es superior al disponible en la caja de origen"
                ];

                return $this->render($this->strRuta.'trasladar', [ 
                    'model' => $model,
                    'data' => $rta
                ]);
            }

            $cajaOrigen->caja_monto = $cajaOrigen->caja_monto - $model->monto;
            $cajaDestino->caja_monto = $cajaDestino->caja_monto + $model->monto;

            $cajaOrigen->save();
            $cajaDestino->save();

            // Movimiento de salida de la caja de origen
            $movimiento = new Movimientos();
            $movimiento->movimiento_fecha = date('Y-m-d H:i:s');
            $movimiento->movimiento_monto = $model->monto;  
            $movimiento->fk_caj_cajas = $model->caja_destino;
            $movimiento->fk_caj_tipo_movimiento = 6;
            $movimiento->movimiento_observacion = "Traslado a la caja " . $cajaDestino->caja_descripcion;
            $movimiento->fc = date('Y-m-d H:i:s');
            $movimiento->uc = $_SESSION['usuario_sesion']['usuarios_id'];
            $movimiento->save();

            // Movimiento de entrada a la caja de destino
            $movimiento = new Movimientos();
            $movimiento->movimiento_fecha = date('Y-m-d H:i:s');
            $movimiento->movimiento_monto = $model->monto;  
            $movimiento->fk_caj_cajas = $model->caja_destino;
            $movimiento->fk_caj_tipo_movimiento = 7;
            $movimiento->movimiento_observacion = "Traslado desde la caja " . $cajaOrigen->caja_descripcion;
            $movimiento->fc = date('Y-m-d H:i:s');
            $movimiento->uc = $_SESSION['usuario_sesion']['usuarios_id'];
            $movimiento->save();

            return $this->redirect(['index']);
        }

        return $this->render($this->strRuta.'trasladar', [ 
            'model' => $model 
        ]);
    }
}
