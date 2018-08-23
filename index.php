<?php

    /**
     * @author:     Reynier Reytor Vega
     * @copyright   Easycubasoft 10/06/2015
     */
    
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', realpath(dirname(__FILE__)) . DS);
    define('APP_PATH', ROOT . 'core' . DS);
    include( APP_PATH . "Easy_Autoload.php");


    //Easy_Session::start();
    //new Easy_Config();

    /*function __autoload($app_class)
    {
        Easy_Autoload::Easyload($app_class);
    }*/
	function loadClass($app_class){
		Easy_Autoload::Easyload($app_class);
	}
	spl_autoload_register('loadClass');
	
	Easy_Session::start();
    new Easy_Config();
	

    try{
        Easy_Bootstrap::run(new Easy_Request);
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

?>
