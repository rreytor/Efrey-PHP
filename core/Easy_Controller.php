<?php

/**
 * @desc        Class Easy_Controller, se definen las funciones necesarias para los controladores que heredan de ella
 * @author:     Reynier Reytor Vega
 * @copyright   Easycubasoft 10/06/2015
 */


abstract class Easy_Controller
{
    protected $_view;
    protected $_request;
    protected $_arr_lang;
    
    public function __construct($load = false) {
        if($load == false)            
        {
            $this->_request = new Easy_Request();
            //cargo la configuracion de la aplicacion   
            $confic_app = ROOT . 'app'. DS . APP_FOLDER_NAME . DS .'config' . DS . 'App_Config.php';        
            
            if(is_readable($confic_app))
                require $confic_app;
            else
            {
                $r = ROOT . 'app'. DS . APP_FOLDER_NAME . DS .'config' . DS;
                new Easy_Error("UUPS!!! No existe el fichero (<strong style='color: #0000ff'>App_Config</strong>) en la ruta $r","error");
                exit;
            }

            
            $this->_view = new Easy_View($this->_request);
            
            if(defined("APP_LANG"))
                if(APP_LANG != null)
                {
                    $lang_file = ROOT . 'app'. DS . APP_FOLDER_NAME . DS .'config' . DS.'App_lang_'.APP_LANG.'.php';                 

                    if(is_readable($lang_file))
                    {
                        $_arr_lang = array();
                        require $lang_file;                        
                        $this->_arr_lang = $_arr_lang;
                        $this->assign("_arr_lang", $_arr_lang);
                    }
                }
        }
        else{
            $this->_request = new Easy_Request();
            $this->_view = new Easy_View($this->_request);
        }
    }

    /**
     * @desc Función de carácter obligatorio en cada controlador, ya que es la que se carga por defecto o en caso de
     * hacer una llamada a una función que no exista en ese controlado.
     */
    //abstract public function index();

    /**
     * @desc Cargar el modelo que se necesita para encuestar la base de datos
     * @param $mod Nombre del modelo a cargar sin la palabra Model
     * @return La clase del modelo que se llama, si no existe el modelo creado y existe la tabla en la base de datos
     * se retorna la clase Easy_GenericModel la cual permite ejecutar las funciones definidas en el Easy_Model.
     *
     * @throws Easy_Error en caso del que modelo o la tabla de la bases de datos no exista
     */
    protected function loadModel($mod)
    {   
        $modelo = $mod . 'Model';
        $rutaModelo = ROOT . 'app'.DS.APP_FOLDER_NAME.DS.'models' . DS . $modelo . '.php';

        if(is_readable($rutaModelo)){
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        }
        else{
            $model = new Easy_GenericModel($mod);
            if($model->checkTable())
                return $model;
            else{
                new Easy_Error("UUPS!!! El modelo (<strong style='color: #0000ff'>'".$mod."'</strong>) no existe","error");
                exit;
            }

        }
    }

    /**
     * @desc Carga un controlador para poder hacer uso de sus funciones, permitiendo la reusabilidad de funciones.
     * @param $controller nombre del controlador que se desea cargar sin la palabra Controller
     * @return retorna la clase del controlador si existe de lo contrario lanza un mensaje de error.
     */
    protected function loadController($controller)
    {
        $controller = $controller . 'Controller';
        $rutaController = ROOT . 'app'.DS.APP_FOLDER_NAME.DS.'controllers' . DS . $controller . '.php';

        if(is_readable($rutaController)){
            require_once $rutaController;
            $cont = new $controller(true);
            return $cont;
        }
        else {
            new Easy_Error("UUPS!!! El controlador (<strong style='color: #0000ff'>'".$controller."'</strong>) no existe","error");
            exit;
        }
    }

    /**
     * @desc Incluir una libreria de terceros, queda para el desarrollador la declaración de los objetos de la misma.
     * @param $libreria Nombre de la libreria, el mismo debe ser el nombre de la carpeta y el nombre del fichero a cargar
     * @return No retorna nada solo incluye la libreria, queda por parte del desarrollador la declaración de la misma.
     */
    protected function getLibrary($libreria)
    {
        $rutaLibreria = ROOT . 'libs' . DS . $libreria .DS . $libreria . '.php';
        
        if(is_readable($rutaLibreria)){
            require_once $rutaLibreria;
        }
        else{
            new Easy_Error("UUPS!!! La libría: (<strong style='color: #0000ff'>'".$libreria."'</strong>) no existe","error");
            exit;
        }
    }

    /**
     * @desc Obetiene la información enviada por POST o por GET combertida a texto en case de pasar código HTML.
     * @param $clave Nombre del campo enviado por POST o por GET
     * @return Valor del campo enviado por POST o GET si no esta definido o esta vacia se retorna false
     */
    protected function getTexto($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return $_POST[$clave];
        }
        elseif(isset($_GET[$clave]) && !empty($_GET[$clave]))
        {
            $_GET[$clave] = htmlspecialchars($_GET[$clave], ENT_QUOTES);
            return $_GET[$clave];
        }
        else{
            return false;
        }
    }

    /**
     * @desc Obetiene la información enviada por POST o por GET filtrada a entero.
     * @param $clave Nombre del campo enviado por POST o por GET
     * @return Valor del campo enviado por POST o GET si no esta definido o esta vacia se retorna 0
     */
    protected function getInt($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave])){
            $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return $_POST[$clave];
        }
        elseif(isset($_GET[$clave]) && !empty($_GET[$clave])){
            $_GET[$clave] = filter_input(INPUT_GET, $clave, FILTER_VALIDATE_INT);
            return $_GET[$clave];
        }
        
        return 0;
    }

    /**
     * @desc Redireccionar a un controlado especifico, si no se pasa nada redirecciona a la raiz del sitio
     * @param bool $ruta
     */
    protected function redireccionar($ruta = false)
    {
        if($ruta){
            header('location:' . BASE_URL . $ruta);
            exit;
        }
        else{
            header('location:' . BASE_URL);
            exit;
        }
    }

    /**
     * @desc Redireccionar a un sitio externo
     * @param bool $ruta
     */
    protected function redireccionExterna($ruta)
    {
        if($ruta){
            header('location:' . $ruta);
            exit;
        }
    }

    /**
     * @desc Filtrar(castear) una variable a entero, si no es un entero retorna 0
     * @param $int informacion a filtrar
     *
     * @return int
     */
    protected function filtrarInt($int)
    {
        $int = (int) $int;
        
        if(is_int($int)){
            return $int;
        }
        else{
            return 0;
        }
    }

    /**
     * @desc Obtener un parametro enviado por POST dato su identificador
     * @param $clave del campo a obtener
     *
     * @return mixed
     */
    protected function getPostParam($clave)
    {
        if(isset($_POST[$clave])){
            return $_POST[$clave];
        }
    }

    /**
     * @desc Obtener un parametro enviado por GET dato su identificador
     * @param $clave del campo a obtener
     *
     * @return mixed
     */
    protected function getGetParam($clave)
    {
        if(isset($_GET[$clave])){
            return $_GET[$clave];
        }
    }

    /**
     * @desc Enviar un mensaje rapido a la vista, se utiliza para enviar mensajes de informacion al usuario
     * @param $msg mensaje a enviar
     * @param bool $perman si se pasa como true se mantiene el mensaje activo hasta que se redefina
     */
    protected function setFlashMessage($msg,$perman=false)
    {        
        Easy_Session::register(array("flashMessage"=>$msg,"flashMessagePerman"=>$perman));
    }

    /**
     * @desc Optener el mensaje rapido eniado a la vista.
     * @return un arreglo con el mensaje y si este es permanente con los key array("flashMessage"=>$msg,"flashMessagePerman"=>$perm)
     */
    protected function getFlashMessage()
    {
        if(Easy_Session::checkSession("flashMessage"))
        {
            $msg = Easy_Session::get("flashMessage");
            $perm = Easy_Session::get("flashMessagePerman");
            return array("flashMessage"=>$msg,"flashMessagePerman"=>$perm);
        }
        else{
            return false;
        }
    }


    /**
     *@desc Chequea si una petición se realizó mediante AJAX
     */
    protected function isAjaxRequest()
    {
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @desc Función para asignar acceso a determniada función, si el usuario logueado tiene acceso se envia la variable <b>_login</b> a la vista para comprobar acceso
     * @param string $nivel rol o roles que tendran acceso a la funcion en caso de pasar mas de uno ej: calcolaeta:operador:escritor
     * @param string $redirec lugar donde enviar el usuario que no tenga acceso a la función
     * @param string $msg mensaje a enviar al usuario
     */
    protected function getAccess($nivel="all",$redirec = "login",$msg="No tiene suficientes privilegios.")
    {        
        $acces = false;
        $l = explode(":", $nivel);
                
        if(Easy_Session::checkSession("login"))
        {            
            if($nivel == "all")
            {
                $this->assign("_login",true);
                return true;                
            }
            else
            {
               $rol = Easy_Session::get("user_rol"); 
               
               if(count($l) >= 1)
               {
                   foreach($l as $r)
                   {
                       if($r == $rol)
                       {   
                           $this->assign("_login",true);
                           return true;                            
                       }
                       else {
                           $acces = false; 
                        }
                   }
               }
               else
               {
                    if($rol == $nivel)
                    {
                        $this->assign("_login",true);
                        return true;
                    }
                    else
                    {
                        $acces = false;
                    }
               }
            }
            
            if($acces == false)
            {   
                $this->setFlashMessage($msg);
                $this->redireccionar($redirec);
                exit;
            }
        }
        else
        {
            $this->setFlashMessage($msg);
            $this->redireccionar($redirec);
        }
    }

    /**
     * @desc para encodar a JSON
     * @param $arr elemento a codificar
     *
     * @return string
     */
    protected function JEncode($arr)
    {
       return json_encode($arr);
    }

    /**
     * @desc para desencodar JSON
     * @param $arr elemento a decodificar
     *
     * @return string
     */
    protected function JDecode($arr)
    {
        return json_decode(stripslashes($arr));
    }

    /**
     * @desc Obtener loas argumentos(parametros) pasados por url
     * @return array
     */
    function getUrlParam()
    {
        return $this->_request->getArgs();
    }

    /**
     * @dec Enviar información a las vistas
     * @param $var nombre de la variable con la que estara disponible en la vista
     * @param $value información deseada
     */
    protected function assign($var,$value)
    {
        $this->_view->assign($var,$value);
    }

    /**
     * @desc Compila la vista deseada y la muestra en pantalla
     * @param      $view vista a compilar
     * @param bool $ajax si se pasa en true compila solo la vista sin el layout, logrando compativilidad con AJAX
     */
    protected function renderizar($view,$ajax = false)
    {
        if($ajax)
            $this->_view->renderizar($view,true);
        else{
            if($this->isAjaxRequest())
                $this->_view->renderizar($view,true);
            else
                $this->_view->renderizar($view,false);
        }

    }

    /**
     * @desc Activa uno o varios ficheros css en la vista que se compile
     * @param $css fichero(s) css a activar en la vista, si se pasa mas de uno es con una arreglo.
     *
     */
    protected function setCss($css)
    {
        if(!is_array($css))
        {
            $pos = strpos($css,",");
            if($pos != false)
            {
                $css = explode(",",$css);
            }
        }

        if(is_array($css))          
            $this->_view->setCss($css);
        else
            $this->_view->setCss(array($css));
    }

    /**
     * @desc Activa uno o varios ficheros js en la vista que se compile
     * @param $js fichero(s) js a activar en la vista, si se pasa mas de uno es con una arreglo.
     *
     */
    protected function setJs($js)
    {
        if(!is_array($js))
        {
            $pos = strpos($js,",");
            if($pos != false)
            {
                $ar_js = explode(",",$js);
                $js = array();
                foreach($ar_js as $item)
                {
                    $js[] = trim($item);
                }
            }
        }
        if(is_array($js))          
            $this->_view->setJs($js);
        else
            $this->_view->setJs(array($js));
    }

    /**
     * @desc para pasar la dirección personalizada de un fichero css
     * @param $cssPath camino completo al fichero css
     */
    protected function setCssCustomPath($cssPath)
    {
        $this->_view->setCssCustomPath($cssPath);            
    }

    /**
     * @desc para activar el layout a utilizar a la hora de compilar la vista
     * @param $layout
     */
    protected function setLayout($layout)
    {
        $this->_view->setLayout($layout);
    }

    /**
     * @desc Cargar los helpers a las vistas
     * @param $helper a cargar
     *
     * @throws Exception
     */
    protected function loadHelper($helper)
    {
        if(is_array($helper))
            $this->_view->loadHelper($helper);
        else
            $this->_view->loadHelper(array($helper));
    }

    /**
     * @desc para obtener el objeto(enviroment) de twig, pudiendo acceder a sus funciones
     * @return Twig_Environment
     */
    protected function TwigEnv()
    {
        return $this->_view->getTwigObj();
    }

}

?>