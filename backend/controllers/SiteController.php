<?php

namespace backend\controllers;

use app\models\Usuarios;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'olvido', 'reestablecer-clave'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $objUsuarios = new Usuarios();

        if ($objUsuarios->load(Yii::$app->request->post()))
        {
            $post = Yii::$app->request->post()["Usuarios"];

            $arrUsuario = Usuarios::find()
                ->where(["usuarios_correo" => $post["usuarios_correo"]])
                ->all();

            if (count($arrUsuario) != 1)
            {
                $objUsuarios->usuarios_clave = "";
                return $this->render('login', [
                    'usuario' => $objUsuarios,
                    'data' => [
                        "error" => true,
                        "mensaje" => "No se pudo recuperar el usuario",
                    ]
                ]);
            }

            if ($arrUsuario[0]["fk_par_estados"] != 1)
            {
                $objUsuarios->usuarios_clave = "";
                return $this->render('login', [
                    'usuario' => $objUsuarios,
                    'data' => [
                        "error" => true,
                        "mensaje" => "El usuario no se encuentra activo, por favor comuníquese con un administrador del sistema",
                    ]
                ]);
            }

            if ($arrUsuario[0]["usuarios_clave"] != md5($objUsuarios->usuarios_clave))
            {
                $objUsuarios->usuarios_clave = "";
                return $this->render('login', [
                    'usuario' => $objUsuarios,
                    'data' => [
                        "error" => true,
                        "mensaje" => "La contraseña no es correcta",
                    ]
                ]);
            }

            unset($arrUsuario[0]["usuarios_clave"]);

            Yii::$app->session->set('usuario_sesion', $arrUsuario[0]);
                
            return $this->render('/layouts/blank');
        }

        $layout = 'blank';

        return $this->render('login', [
            'usuario' => $objUsuarios,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionOlvido()
    {
        $usuario = new Usuarios();

        if ($this->request->isPost) 
        {
            $fechaActual = date('Y-m-d H:i:s');
            $fechaVencimiento = strtotime('+15 min', strtotime($fechaActual));
            $fechaVencimiento = date('Y-m-d H:i:s', $fechaVencimiento);

            $usuario = Usuarios::findOne(['usuarios_correo' => $this->request->post()['Usuarios']['usuarios_correo']]);

            $usuario->usuarios_token = strval(rand(1111, 9999));
            $usuario->usuarios_vto_token = $fechaVencimiento;

            $usuario->save();

            $cuerpo = 'Su codigo de seguridad es: '.$usuario->usuarios_token.'';

            Yii::$app->mailer->compose()
                ->setFrom('ayuda@upvendor.com')
                ->setTo($usuario->usuarios_correo)
                ->setSubject('UPVENDOR - Recuperación de contraseña')
                ->setHtmlBody('<b>'.$cuerpo.'</b>')
                ->send();

            
            $usuario = new Usuarios();
            return $this->render('login', [
                'usuario' => $usuario,
                'data' => [
                    "error" => true,
                    "mensaje" => 'Se ha enviado a su correo un código para la recuperación de su clave.<br>Estará vigente hasta: '
                        .$fechaVencimiento.
                        '<br><br>Haga clic <a href="http://localhost:8080/index.php?r=site/reestablecer-clave">AQUI</a> para continuar',
                ]
            ]);
        }
        
        return $this->render('/seguridad/usuarios/olvideClave', [
            'model' => $usuario,
        ]);
    }

    public function actionReestablecerClave()
    {
        if ($this->request->isPost)
        {
            $recuperaClave = $this->request->post();

            $usuario = new Usuarios();
            $usuario = Usuarios::findOne(['usuarios_correo' => $recuperaClave['usuarios_correo']]);

            // Validar fecha de vencimiento del token
            if (strtotime(date('Y-m-d H:i:s')) > strtotime($usuario['usuarios_vto_token']))
            {
                $usuario = new Usuarios();
                return $this->render('login', [
                    'usuario' => $usuario,
                    'data' => [
                        "error" => true,
                        "mensaje" => 'El código de seguridad ha expirado, por favor solicite uno nuevo',
                    ]
                ]);
            }

            // Validar el token
            if ($recuperaClave['usuarios_token'] != $usuario['usuarios_token'])
            {
                return $this->render('reestablecerClave', [
                    'data' => [
                        'error' => 'true',
                        'mensaje' => 'El código de seguridad es incorrecto'
                    ]
                ]);
            }

            // Validar las contraseñas
            if ($recuperaClave['usuarios_nuevaclave'] != $recuperaClave['usuarios_repnuevaclave'])
            {
                return $this->render('reestablecerClave', [
                    'data' => [
                        'error' => 'true',
                        'mensaje' => 'Las claves no coinciden, por favor valide'
                    ]
                ]);
            }

            $usuario->usuarios_clave = md5($recuperaClave['usuarios_nuevaclave']);
            $usuario->fm = date('Y-m-d H:i:s');
            $usuario->um = $usuario->usuarios_id;

            $usuario->save();

            return $this->render('reestablecerClave', [
                'data' => [
                    'error' => 'false',
                    'mensaje' => 'La clave se reestableció con éxito'
                ]
            ]);
        }

        return $this->render('reestablecerClave', [
        ]);
    }
}
