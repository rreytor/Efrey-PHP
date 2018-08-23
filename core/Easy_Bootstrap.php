<?php

    /**
     * @desc        Class Easy_Bootstrap, se encarga de verificar y enrutar las peticiones realizadas
     * @author:     Reynier Reytor Vega
     * @copyright   Easycubasoft
     */
 
class Easy_Bootstrap
{
    public static function run(Easy_Request $peticion)
    {
        $controller = $peticion->getControlador() . 'Controller';
        $rutaControlador = ROOT . 'app' . DS . APP_FOLDER_NAME . DS . 'controllers' . DS . $controller . '.php';

        $metodo = $peticion->getMetodo();
        $args = $peticion->getArgs();

        if(is_dir(ROOT . 'app' . DS . APP_FOLDER_NAME))
        {
            if(is_readable($rutaControlador))
            {
                require_once $rutaControlador;
                $controller = new $controller;

                if(is_callable(array($controller, $metodo)))
                {
                    //$metodo = $peticion->getMetodo();

                    if(isset($args)){
                        call_user_func_array(array($controller, $metodo), $args);
                    }
                    else{
                        call_user_func(array($controller, $metodo));
                    }
                }
                else{
                    //si el metodo no existe se llama al metodo index y se le pasa el metodo llamado como argumento
                    if(empty($args))
                        call_user_func_array(array($controller, "index"), array($metodo));
                    else
                        call_user_func_array(array($controller, "index"), array_merge(array($metodo),$args));
                    exit;
                   /* new Easy_Error("UUPS!!! El metodo (<strong style='color: #0000ff'>'".$metodo."'</strong>) no existe en el controlador ".$peticion->getControlador(),"error");
                    exit;*/
                }
            }
            else {

                $controller = "routeController";
                $rutaControlador = ROOT . 'app' . DS . APP_FOLDER_NAME . DS . 'controllers' . DS . $controller . '.php';
                if(is_readable($rutaControlador))
                {
                    require_once $rutaControlador;
                    $controller = new $controller;

                    $arr_ruta = array("controller"=>$peticion->getControlador(),"metodo"=>$metodo,"arg"=>$args);

                    call_user_func_array(array($controller, "index"), array($arr_ruta));
                    exit;
                }
                else{
                    new Easy_Error("UUPS!!! El controlador (<strong style='color: #0000ff'>'".$peticion->getControlador()."'</strong>) no existe","error");
                    exit;
                }
            }
        }
        else
        {
            if(APP_FOLDER_NAME_BY_DEFAULT == NULL)
            {
                new Easy_Error("UUPS!!! la aplicación (<strong style='color: #0000ff'>'".APP_FOLDER_NAME."'</strong>) no existe","404");
                exit;
            }
        }
        

    }
}

?>