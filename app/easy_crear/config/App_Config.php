<?php

/**
* @desc      Fichero de configuracion de la aplicación 
* @author    Reynier Reytor Vega
* @copyright Easycubasoft 03/06/2015
*/
/*****************************************************************************************
                          DEFINICION DE DATOS DE LA APLICACION
*****************************************************************************************/

define('DEFAULT_LAYOUT', 'default');                                                            //template por defecto
define('DEFAULT_COMPILER', 'Twig');                                                             //motor de plantillas por defecto puede Smarty o Twig
//define('DEFAULT_COMPILER', 'Smarty');                                                             //motor de plantillas por defecto puede Smarty o Twig


/*****************************************************************************************
                         DEFINICION DE DATOS DE LA COMPAÑIA
*****************************************************************************************/

define('APP_NAME',      "EFREY-PHP");                                                            	//titulo del sitio
define('APP_SLOGAN',    "Ahora programar es + fácil");											//slogan del sitio
define('APP_COMPANY',   "EASYCUBASOFT");                                                        //compañia
define('APP_MAILTO',    'mailto:rreytor@nauta.cu');	                                			//correo de la compañia

/*****************************************************************************************
                        DEFINICIONES DE LAS CONECIONES A LA BASE DE DATOS
*****************************************************************************************/
$easy_db_data = array();
$easy_db_data['default']['host']        =   "localhost";                                           //hosting de la base de datos
$easy_db_data['default']['user']        =   "root";                                        		//usuario
$easy_db_data['default']['pass']        =   "";                                           	//contraseña
$easy_db_data['default']['db_name']     =   "";                                         //nombre de la base de datos
$easy_db_data['default']['dbchar']      =   "utf8";                                             //codificacion a usar
$easy_db_data['default']['db_driver']   =   "mysql";                                            //tipo de servidor

/*****************************************************************************************
                          AUTOCARGA DE MODULOS  
*****************************************************************************************/
$easy_auto_load = array();
$easy_auto_load['helpers'] = array('HEasy_Html','HEasy_Date','HEasy_File');									//autocarga de helpers
$easy_auto_load['plugins'] = array();


/*****************************************************************************************
                         COSAS UTILIES 
*****************************************************************************************/



/*****************************************************************************************
                         PARA DATOS DE LA SESSION 
*****************************************************************************************/
define("SESSION_TIME",360);                                                                     //tiempo de la session en segundos    

/*****************************************************************************************
*****************************************************************************************/

Easy_Session::register(array("easy_db_data"=>$easy_db_data,"easy_auto_load"=>$easy_auto_load));
/*****************************************************************************************
*****************************************************************************************/

?>