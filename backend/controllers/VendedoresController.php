<?php

namespace backend\controllers;

use app\models\Vendedores;
use app\models\VendedoresSearch;
use app\models\Usuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class VendedoresController extends Controller
{
    private $strRuta = "/ventas/vendedores/";
    private $intOpcion = 6002;

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

        $searchModel = new VendedoresSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($vendedor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($vendedor_id),
        ]);
    }
    
    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Vendedores();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->vendedor_nombre_completo = mb_strtoupper($model->vendedor_nombre_completo, 'UTF-8');
                $model->fc = date('Y-m-d H:i:s');
                $model->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];

                $model->crear_usuario = $this->request->post()['Vendedores']['crear_usuario'];

                $model->save();

                if ($model->crear_usuario == 1) {
                    // Definir el nombre y apellido del usuario
                    $arrNombre = explode(' ', $model->vendedor_nombre_completo);
                    $strNombre = $arrNombre[0];
                    $strApellido = $arrNombre[1];

                    // Crear el usuario
                    $usuario = new Usuarios();
                    $usuario->usuarios_nombre = $strNombre;
                    $usuario->usuarios_apellido = $strApellido;
                    $usuario->usuarios_telefono = $model->vendedor_telefono;
                    $usuario->usuarios_correo = $model->vendedor_correo_electronico;
                    $usuario->usuarios_clave = md5('12345678');
                    $usuario->fk_seg_perfiles = 3; // 3 - Empleado
                    $usuario->fk_par_estados = 1;
                    $usuario->fc = date('Y-m-d H:i:s');
                    $usuario->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];
                    
                    $usuario->save();

                    $model->fk_seg_usuarios = $usuario->usuarios_id;
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'vendedor_id' => $model->vendedor_id]);
                }
            }
        } 
        else {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($vendedor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($vendedor_id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->vendedor_nombre_completo = mb_strtoupper($model->vendedor_nombre_completo, 'UTF-8');
                $model->fm = date('Y-m-d H:i:s');
                $model->um = $_SESSION['as_usuario_sesion']['usuarios_id'];

                if (isset($this->request->post()['Vendedores']['crear_usuario'])) {
                    $model->crear_usuario = $this->request->post()['Vendedores']['crear_usuario'];
                }

                if ($model->crear_usuario == 1) {
                    // Definir el nombre y apellido del usuario
                    $arrNombre = explode(' ', $model->vendedor_nombre_completo);
                    $strNombre = $arrNombre[0];
                    $strApellido = $arrNombre[1];

                    // Crear el usuario
                    $usuario = new Usuarios();
                    $usuario->usuarios_nombre = $strNombre;
                    $usuario->usuarios_apellido = $strApellido;
                    $usuario->usuarios_telefono = $model->vendedor_telefono;
                    $usuario->usuarios_correo = $model->vendedor_correo_electronico;
                    $usuario->usuarios_clave = md5('12345678');
                    $usuario->fk_seg_perfiles = 3; // 3 - Empleado
                    $usuario->fk_par_estados = 1;
                    $usuario->fc = date('Y-m-d H:i:s');
                    $usuario->uc = $_SESSION['as_usuario_sesion']['usuarios_id'];
                    
                    $usuario->save();

                    $model->fk_seg_usuarios = $usuario->usuarios_id;
                }

                if ($model->save()) {
                    return $this->redirect(['view', 'vendedor_id' => $model->vendedor_id]);
                }
            }
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($vendedor_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($vendedor_id)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($vendedor_id)
    {
        if (($model = Vendedores::findOne(['vendedor_id' => $vendedor_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
