<?php

namespace backend\controllers;

use app\models\Permisos;
use app\models\PermisosSearch;
use kartik\icons\Icon;
use stdClass;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PermisosController implements the CRUD actions for Permisos model.
 */
class PermisosController extends Controller
{
    private $strRuta = "/seguridad/permisos/";
    private $intOpcion = 1003;

    /**
     * Lists all Permisos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error']) return $this->render('/site/error', [ 'data' => $rta ]);

        return $this->render($this->strRuta.'index');
    }

    public function actionGuardarPermisos()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'c');
        if ($rta['error']){
            $jsonRta = new stdClass;
            $jsonRta->error = true;
            $jsonRta->mensaje = $rta['mensaje'];

            echo json_encode($jsonRta);
            exit();
        }

        // Se obtienen los datos ue vienen en el post
        $post = Yii::$app->request->post();

        // Se eliminan todos los permisos del perfil antes de insertar los nuevos
        Permisos::deleteAll(['fk_seg_perfiles' => $post['perfil']]);

        // Se recorren los permisos que vienen del formulario
        foreach ($post['permisos'] as $key => $value) 
        {
            // Se identifican la opción y la acción
            // Las opciones se encuentran en la tabla tb_seg_opciones
            // Las acciones son (C)reate, (R)ead, (U)pdate, (D)elete, (L)ist y (V)iew
            $arrOpcion = explode('_', $value['name']);
            $intOpcion = $arrOpcion[0];
            $chrAccion = $arrOpcion[1];

            // Se consulta si para el perfil y la opción ya hay acciones permitidas en la base de datos
            $rslConsulta = (new Query())
                ->select('*')
                ->from('tb_seg_permisos')
                ->Where('fk_seg_perfiles = '.$post['perfil'])
                ->andwhere('fk_seg_opciones = '.$intOpcion)
                ->all();
            
            // Si el permiso no existe, se crea un nuevo registro
            if (count($rslConsulta) == 0)
            {
                $objPermiso = new Permisos();
                $objPermiso->fk_seg_perfiles = $post['perfil'];
                $objPermiso->fk_seg_opciones = $intOpcion;
            }
            else // Pero si el permiso existe, se carga el objeto existente
                $objPermiso = Permisos::findOne($rslConsulta[0]['permisos_id']);
            
            // Se marca la acción como permitida y se guardan los cambios
            $objPermiso->$chrAccion = 1;
            $objPermiso->save();
        }

        $jsonRta = new stdClass;
        $jsonRta->error = false;
        $jsonRta->mensaje = 'El proceso se realizó con éxito';

        echo json_encode($jsonRta);
    }
    
    public function actionConsultarPermisos()
    {
        $rta = PermisosController::validarPermiso($this->intOpcion, 'r');
        if ($rta['error'])
            return $this->render('/site/error', [ 'data' => $rta ]);

        $intPerfil = Yii::$app->request->post()['perfil'];

        $sqlSentencia = "select
                opci.opciones_id, opci.fk_seg_modulos, opci.opciones_nombre,
                modu.modulos_descripcion as modulo,
                coalesce(perm.c, 0) as c, coalesce(perm.r, 0) as r, coalesce(perm.u, 0) as u, coalesce(perm.d, 0) as d, coalesce(perm.l, 0) as l, coalesce(perm.v, 0) as v, coalesce(perm.m, 0) as m
            from tb_seg_opciones opci
            join tb_seg_modulos modu on (opci.fk_seg_modulos = modu.modulos_id) 
            left join tb_seg_permisos perm on (perm.fk_seg_opciones = opci.opciones_id and perm.fk_seg_perfiles = ".$intPerfil.")
            where modu.fk_par_estados = 1
            and opci.fk_par_estados = 1";
        
        $cnxConexion = Yii::$app->db;

        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);

        $rslResultado = $stmtSentencia->queryAll();

        echo json_encode($rslResultado);
    }

    public static function validarPermiso($intOpcion, $chrAccion)
    {
        if (!isset($_SESSION['usuario_sesion']))
        {
            return [
                'error' => true,
                'mensaje' => 'La sesión ha caducado',
            ];
        }

        $rslConsulta = (new Query())
            ->select($chrAccion)
            ->from('tb_seg_permisos')
            ->Where('fk_seg_perfiles = '.$_SESSION['usuario_sesion']['fk_seg_perfiles'])
            ->andwhere('fk_seg_opciones = '.$intOpcion)
            ->all();
        
        if (count($rslConsulta) != 1 || $rslConsulta[0][$chrAccion] == 0)
            return [
                'error' => true,
                'mensaje' => 'Usted no posee permisos para ejecutar esta acción',
            ];

        return [
            'error' => false,
            'mensaje' => ''
        ];
    }

    public static function construirMenu()
    {
        $arrMenu = [];

        // Si no se encuentra un usuario en sesión se devuelve un menú que sólo contine la opción de loguearse
        if (!isset($_SESSION['usuario_sesion']))
        {
            array_push($arrMenu, ['label' => 'Login', 'url' => ['/site/login']]);
            return $arrMenu;
        }

        // Se consultan todos lo permisos de consulta del perfil del usuario que está en sesión
        // Se usa la acción de consulta ya que es con la que inicia cada pantalla de la aplicación
        $sqlSentencia = "select
            opci.fk_seg_modulos, modu.modulos_descripcion as modulo, modu.modulos_icono as icono, 
            opci.opciones_id, opci.opciones_nombre, opci.opciones_enlace
            from tb_seg_opciones opci
            join tb_seg_modulos modu on (opci.fk_seg_modulos = modu.modulos_id) 
            left join tb_seg_permisos perm on (perm.fk_seg_opciones = opci.opciones_id and perm.fk_seg_perfiles = ".$_SESSION['usuario_sesion']['fk_seg_perfiles'].")
            where modu.fk_par_estados = 1
            and opci.fk_par_estados = 1
            and perm.m = 1
            and opci.opciones_enlace != ''
            order by opci.fk_seg_modulos asc, opci.opciones_nombre asc";

        // Ejecutar la consulta de los permisos del perfil
        $cnxConexion = Yii::$app->db;
        $stmtSentencia = $cnxConexion->createCommand($sqlSentencia);
        $arrPermisos = $stmtSentencia->queryAll();

        // Banderas para la creación del menú
        $intModulo = 0;
        $strModulo = '';
        $arrSubMenu = [];
        
        // Recorrer todos los permisos que se encontraron del perfil
        foreach ($arrPermisos as $key => $value) 
        {   
            // Validar si el módulo que está en el paso del ciclo es diferente al que paso anterior
            if ($intModulo != $value['fk_seg_modulos'])
            {
                // Se agrega el submenú al menú 
                array_push(
                    $arrMenu, 
                    [ 'label'=>$strModulo, 'items'=>$arrSubMenu, ]
                );
                
                // Se cambiá la bandera del menú actual
                $intModulo = $value['fk_seg_modulos'];
            
                // Se cambia el nombre del menú
                $strModulo = '<i class="fas fa-'.$value['icono'].'"></i> '.$value['modulo'];

                // Se crea un nuevo submenu
                $arrSubMenu = [];
            }
            
            // Se agrega la opción al submenú
            array_push(
                $arrSubMenu, 
                [
                    'label'=>$value['opciones_nombre'], 
                    'options' => [
                        'class' => 'text-white'
                    ],
                    'url'=>[
                        $value['opciones_enlace'], 
                    ]
                ]
            );
        }
        
        // Se agrega el último submenú al menú
        array_push($arrMenu, ['label'=>$strModulo, 'items'=>$arrSubMenu]);
        
        // Se agrega la opción de cerrar sesión
        array_push(
            $arrMenu, 
            [
                'label' => '<i class="fas fa-user"></i> '.$_SESSION['usuario_sesion']['usuarios_nombre'].' '.$_SESSION['usuario_sesion']['usuarios_apellido'], 
                'items'=>[
                    [
                        'label'=>'Salir', 
                        'url'=>[ '/usuarios/cerrar-sesion' ], 
                    ]
                ]
            ]
        );

        // Se devuelve el menú de acuerdo a los permisos del perfil
        return $arrMenu;
    }
}