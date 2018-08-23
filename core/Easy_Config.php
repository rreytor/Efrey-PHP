<?php

/**
* @desc      Easy_Config aquí se definen todas las variables globales para el sistema
* @author    Reynier Reytor Vega
* @copyright Easycubasoft 13/02/2014
*/

class Easy_Config
{
    function __construct()
    {

        $h = explode(".",$_SERVER['HTTP_HOST']);
        //Entorno de trabajo del servidor D = Desarrollo; P = Producción; si se define en P no se podrá acceder
        //a la aplicación easy_crear
        define('APP_ENVIRONMENT', "D");

        //aplicacion por defecto por si falla la dinámica, si no se define en NULL
        define('APP_FOLDER_NAME_BY_DEFAULT', "salon");
        //define('APP_FOLDER_NAME_BY_DEFAULT', "download");
        //define('APP_FOLDER_NAME_BY_DEFAULT', "salon");
        //define('APP_FOLDER_NAME_BY_DEFAULT', "convention");
        //define('APP_FOLDER_NAME_BY_DEFAULT', "newbeetle");


        //se verifica que existe la aplicación, de no existir se carga la aplicación por defecto
        if(!is_dir(ROOT . 'app' . DS . $h[0]) and APP_FOLDER_NAME_BY_DEFAULT != NULL)
        {
            define('APP_FOLDER_NAME', APP_FOLDER_NAME_BY_DEFAULT);
        }
        else
        {
            define('APP_FOLDER_NAME', $h[0]);
        }

        //define('APP_FOLDER_NAME', "despacho");
        //direccion base del sitio
        define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');

        //carpeta contenedora de los helpers
        define('FOLDER_HELPERS',     APP_PATH."helpers".DS);

        //controlador por defecto
        define('DEFAULT_CONTROLLER', 'index');

        //directorio de Smarty
        define('SMARTY_DIR',   APP_PATH.'Smarty'.DS.'libs'.DS);

        //directorio para los plugin de Smarty
        define('SMARTY_DIR_SYSPLUGINS_FOR_INCLUDE',   SMARTY_DIR.'sysplugins'.DS);

        //directorio  de Twig
        define('TWIG_DIR',   APP_PATH.'Twig'.DS);
    }


}


?>