<?php

namespace backend\controllers;

use app\models\Usuarios;
use common\models\LoginForm;
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
                        'actions' => ['login', 'error'],
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
}
