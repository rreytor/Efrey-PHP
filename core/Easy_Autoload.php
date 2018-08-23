<?php
    /**
     * @desc        Class Easy_Autoload, se encarga de las auto carga de las clases que se necesitan para el sistema
     * @author:     Reynier Reytor Vega
     * @copyright   Easycubasoft 10/06/2015
     */

class Easy_Autoload {

    static function  Easyload($app_class)
    {
        $type = substr($app_class, 0,1);

        switch ($type) {
            case "E":
                $file = APP_PATH . $app_class .".php";
                if(is_readable($file))
                    require_once $file;
                break;
            case "H":
                $file = FOLDER_HELPERS . $app_class .".php";
                if(is_readable($file))
                    require_once $file;
                break;
            case "S":
                $file = SMARTY_DIR . $app_class .".class.php";
                if(is_readable($file))
                    require_once $file;

                $file = SMARTY_DIR_SYSPLUGINS_FOR_INCLUDE . strtolower($app_class) .".php";
                if(is_readable($file))
                    require_once $file;
                break;
            case "T":
                $path = explode("_",$app_class);
                $file = TWIG_DIR;

                $route = "";
                for($i = 0;$i<count($path)-1;$i++){
                    $route .= $path[$i].DS;
                }

                $cant = count($path);

                if(is_readable($file))
                    require_once APP_PATH.$route.$path[$cant-1].".php";

                break;
        }
    }

} 