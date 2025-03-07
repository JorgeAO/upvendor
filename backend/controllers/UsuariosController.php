<?php

namespace backend\controllers;

use app\models\CambioClave;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class UsuariosController extends Controller
{
    private $strRuta = "/seguridad/usuarios/";
    private $intOpcion = 1002;

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

        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render($this->strRuta.'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($usuarios_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'v');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'view', [
            'model' => $this->findModel($usuarios_id),
        ]);
    }

    public function actionCreate()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new Usuarios();

        if ($this->request->isPost && $model->load($this->request->post()))
        {
            $model->usuarios_nombre = mb_strtoupper($model->usuarios_nombre, 'UTF-8');
            $model->usuarios_apellido = mb_strtoupper($model->usuarios_apellido, 'UTF-8');
            $model->usuarios_clave = md5($model->usuarios_clave);
            $model->fc = date('Y-m-d H:i:s');
            $model->uc = $_SESSION['usuario_sesion']['usuarios_id'];

            if ($model->save())
                return $this->redirect(['view', 'usuarios_id' => $model->usuarios_id]);
        } 
        else 
        {
            $model->loadDefaultValues();
        }

        return $this->render($this->strRuta.'create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($usuarios_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = $this->findModel($usuarios_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'usuarios_id' => $model->usuarios_id]);
        }

        return $this->render($this->strRuta.'update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($usuarios_id)
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'd');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $this->findModel($usuarios_id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($usuarios_id)
    {
        if (($model = Usuarios::findOne(['usuarios_id' => $usuarios_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCambiarClave()
    {
        $rta = PermisosController::validarPermiso(1004, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new CambioClave();

        if ($this->request->isPost && $model->load($this->request->post())) 
        {
            $cambioClave = $this->request->post()['CambioClave'];

            // Recuperar el usuario que está en sesión
            $usuario = new Usuarios();
            $usuario = Usuarios::findOne(['usuarios_id' => $_SESSION['usuario_sesion']['usuarios_id']]);

            // Validar que la contraseña acutal ingresada sea correcta
            if ($usuario->usuarios_clave != md5($cambioClave["usuarios_clave"])){
                return $this->render($this->strRuta.'cambiarClave', [
                    'model' => $model,
                    'data' => [
                        "error" => true,
                        "mensaje" => "La clave actual no es correcta",
                    ]
                ]);
            }

            // Validar que las contraseñas nuevas coincidan
            if ($cambioClave['usuarios_nuevaclave'] != $cambioClave['usuarios_repnuevaclave']){
                return $this->render($this->strRuta.'cambiarClave', [
                    'model' => $model,
                    'data' => [
                        "error" => true,
                        "mensaje" => "La claves nuevas no coinciden",
                    ]
                ]);
            }

            // Fijar la nueva contraseña y los datos de auditoría
            $usuario->usuarios_clave = md5($cambioClave['usuarios_nuevaclave']);
            $usuario->fm = date('Y-m-d H:i:s');
            $usuario->um = $_SESSION['usuario_sesion']['usuarios_id'];

            // Guardar los cambios
            if ($usuario->save()) {
                return $this->redirect(['view', 'usuarios_id' => $usuario->usuarios_id]);
            }
        }

        return $this->render($this->strRuta.'cambiarClave', [
            'model' => $model,
        ]);
    }

    public function actionCambiarClaveUsuario($usuarios_id)
    {
        $rta = PermisosController::validarPermiso(1005, 'u');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        $model = new CambioClave();
        $model->usuarios_id = $usuarios_id;

        if ($this->request->isPost && $model->load($this->request->post())) 
        {
            $cambioClave = $this->request->post()['CambioClave'];

            // Validar que las contraseñas nuevas coincidan
            if ($cambioClave['usuarios_nuevaclave'] != $cambioClave['usuarios_repnuevaclave']){
                return $this->render($this->strRuta.'cambiarClaveUsuario', [
                    'model' => $model,
                    'data' => [
                        "error" => true,
                        "mensaje" => "La claves nuevas no coinciden",
                    ]
                ]);
            }

            // Recuperar el usuario a modificar
            $usuario = new Usuarios();
            $usuario = Usuarios::findOne(['usuarios_id' => $usuarios_id]);

            // Fijar la nueva contraseña y los datos de auditoría
            $usuario->usuarios_clave = md5($cambioClave['usuarios_nuevaclave']);
            $usuario->fm = date('Y-m-d H:i:s');
            $usuario->um = $_SESSION['usuario_sesion']['usuarios_id'];

            // Guardar los cambios
            if ($usuario->save()) {
                return $this->redirect(['view', 'usuarios_id' => $usuario->usuarios_id]);
            }
        }

        return $this->render($this->strRuta.'cambiarClaveUsuario', [
            'model' => $model,
        ]);
    }

    public function actionCerrarSesion()
    {
        unset($_SESSION['usuario_sesion']);

        return $this->redirect(['/site/login']);
    }
}