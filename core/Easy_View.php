<?php
/**
 * @desc        Class Easy_View, para renderizar las vistas
 * @author:     Reynier Reytor Vega
 * @copyright   Easycubasoft 10/06/2015
 */


class Easy_View
{
    private $_controlador;
    private $_js;
    private $_css;
    private $_layout;    
    private $_objSmarty;        
    private $_objTwig;
    private $_paramForViewTwig;


    /**
     * Constructo de la clase Easy_View se inicializan las variables necesarias para la clase
     * @param Easy_Request $peticion
     * @throws Exception
     */
    public function __construct(Easy_Request $peticion) 
    {
        $this->_controlador = $peticion->getControlador();
        $this->_js = array();  
        $this->_css = array();  
        $this->_layout = DEFAULT_LAYOUT;

        if(DEFAULT_COMPILER == "Smarty")
        {
            $_objSmarty = new Smarty();
            $_objSmarty->setCompileDir(APP_PATH.'Smarty'.DS.'templates_c');
            $_objSmarty->setConfigDir(APP_PATH.'Smarty'.DS.'configs');
            $_objSmarty->setCacheDir(APP_PATH.'Smarty'.DS.'cache');

            $this->_objSmarty = $_objSmarty;
        }
        else{
            $this->_objTwig = new Twig_Environment(null,array("debug"=>true));
        }
        
        $autoload = Easy_Session::get('easy_auto_load'); 
        $helper = $autoload['helpers'];
        $this->loadHelper($helper);
        
    }

    /**
     * Función para asignar variables a las vistas
     * @param $var
     * @param bool $val
     */
    public function assign($var,$val=false)
    {
        if(DEFAULT_COMPILER == "Smarty"){
            $this->_objSmarty->assign($var,$val);
        }
        else{
            if (is_array($var)) {
                foreach ($var as $_key => $_val) {
                    if ($_key != '') {
                        $this->_paramForViewTwig[$_key] = $_val;
                    }
                }
            }
            else
                $this->_paramForViewTwig[$var] = $val;
        }
    }

    /**
     * Función para renderizar la vista usando Smarty
     * @param $vista
     * @param bool $ajax
     * @throws Exception
     */
    private function renderSmarty($vista, $ajax = false)
    {   
        $this->assign("APP_SLOGAN",APP_SLOGAN);
        $this->assign("APP_COMPANY",APP_COMPANY);
        $this->assign("APP_MAILTO",APP_MAILTO);
        $this->assign("BASE_URL",BASE_URL);
        $this->assign("ROOT",ROOT);
        $this->assign("APP_PATH",APP_PATH);
        $this->assign("APP_NAME",APP_NAME);
        $this->assign("APP_FOLDER_NAME",APP_FOLDER_NAME);
        $this->assign("_layout",$this->_layout);

        $this->assign("year",date("Y"));
        $this->assign("month",date("m"));
        $this->assign("day",date("d"));

        $arrmsg = Easy_Session::get("flashMessage");
        if($arrmsg != false)
        {            
            $this->assign("_flashMessage",$arrmsg);
            if(Easy_Session::get('flashMessagePerman') == false)
                Easy_Session::unregister(array("flashMessage",'flashMessagePerman'));
        }

        $_path_layout  = ROOT . 'app'.DS . APP_FOLDER_NAME . DS .'views'. DS .'layout'. DS .$this->getLayout(). DS;
        $this->_objSmarty->setTemplateDir($_path_layout);
        
        if(count($this->_js)){
            $this->assign("_js",$this->_js);
        } 
        
        if(count($this->_css)){
            $this->assign("_css",$this->_css);
        }
        
        $_layout_ruta_css      = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/layout/' . $this->getLayout() . '/css/';
        $_layout_ruta_img      = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/layout/' . $this->getLayout() . '/img/';
        $_layout_ruta_js       = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/layout/' . $this->getLayout() . '/js/';
        $_ruta_layout          = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/layout/' . $this->getLayout() . '/';

        $_main_nav      = ROOT . 'app'. DS. APP_FOLDER_NAME . DS. 'views'.DS.'layout'.DS.'menu' .DS. 'menu.tpl';
        $_ruta_nav      = ROOT . 'app'. DS. APP_FOLDER_NAME . DS. 'views'.DS.'layout'.DS.'menu' .DS;
        

        $_ruta_view = ROOT . 'app' . DS . APP_FOLDER_NAME . DS  . 'views' . DS . $this->_controlador . DS;
        $view = $_ruta_view . $vista . '.tpl';

        $_view_ruta_img = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/' . $this->_controlador . '/img/';
        $_view_ruta_js = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/' . $this->_controlador . '/js/';
        $_view_ruta_css = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/' . $this->_controlador . '/css/';

        $_ruta_folder_view = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/';


                                                                      
        $this->assign("_layout_ruta_css",$_layout_ruta_css);
        $this->assign("_layout_ruta_img",$_layout_ruta_img);
        $this->assign("_layout_ruta_js",$_layout_ruta_js);
        $this->assign("_ruta_layout",$_ruta_layout);
        $this->assign("_ruta_folder_view",$_ruta_folder_view);

        $this->assign("_content",$view);

        $this->assign("_main_nav",$_main_nav);        
        $this->assign("_ruta_nav",$_ruta_nav);

        $this->assign("_ruta_view",$_ruta_view);
        $this->assign("_view_ruta_img",$_view_ruta_img);
        $this->assign("_view_ruta_js",$_view_ruta_js);
        $this->assign("_view_ruta_css",$_view_ruta_css);

        $this->assign("_path_layout",$_path_layout);
        
        try{
            if($ajax != false)
            {    
                $templatedir = ROOT . 'app' . DS . APP_FOLDER_NAME . DS  . 'views' . DS . $this->_controlador . DS;
                $this->_objSmarty->setTemplateDir($templatedir);
                $this->_objSmarty->display($vista.'.tpl');
                exit;
            }
            
            $this->_objSmarty->display($this->getLayout().'.tpl');
            exit;
        }
        catch ( Exception $e)
        {
            echo $e;
            throw new Exception("Error cargando la vista indicada");
        }
    }

    /**
     * Función para renderizar la vista usando Twig
     * @param $vista
     * @param bool $ajax
     * @throws Exception
     */
    private function renderTwig($vista, $ajax = false)
    {
        $param = array();

        $arrmsg = Easy_Session::get("flashMessage");
        if($arrmsg != false)
        {
            $param["_flashMessage"] = $arrmsg;
            if(Easy_Session::get('flashMessagePerman') == false)
                Easy_Session::unregister(array("flashMessage",'flashMessagePerman'));
        }

        if(count($this->_js)){
            $param["_js"] = $this->_js;
        }

        if(count($this->_css)){
            $param["_css"] = $this->_css;
        }


        $_layout_ruta_css = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/layout/' . $this->getLayout() . '/css/';
        $_layout_ruta_img = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/layout/' . $this->getLayout() . '/img/';
        $_layout_ruta_js  = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/layout/' . $this->getLayout() . '/js/';
        $_ruta_layout     = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/layout/' . $this->getLayout() . '/';

        $_main_nav  = ROOT . 'app'. DS. APP_FOLDER_NAME . DS. 'views'.DS.'layout'.DS.'menu' .DS. 'menu.twig';
        $_ruta_nav  = ROOT . 'app'. DS. APP_FOLDER_NAME . DS. 'views'.DS.'layout'.DS.'menu' .DS;

        $_ruta_view = ROOT . 'app' . DS . APP_FOLDER_NAME . DS  . 'views' . DS . $this->_controlador . DS;
        $view = $_ruta_view . $vista . '.twig';

        $_view_ruta_img = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/' . $this->_controlador . '/img/';
        $_view_ruta_js  = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/' . $this->_controlador . '/js/';
        $_view_ruta_css = BASE_URL . 'app/'. APP_FOLDER_NAME . '/views/' . $this->_controlador . '/css/';

        $_path_layout  = ROOT . 'app'.DS . APP_FOLDER_NAME . DS .'views'. DS .'layout'. DS .$this->getLayout(). DS;

        //variables para el layout
        $param["_layout_ruta_css"]  = $_layout_ruta_css;
        $param["_layout_ruta_img"]  = $_layout_ruta_img;
        $param["_layout_ruta_js"]   = $_layout_ruta_js;
        $param["_ruta_layout"]      = $_ruta_layout;

        $param["_content"]          = $view;

        //variables para el menu
        $param["_main_nav"]         = $_main_nav;
        $param["_ruta_nav"]         = $_ruta_nav;

        //variables para la vista
        $param["_ruta_view"]        = $_ruta_view;
        $param["_view_ruta_img"]    = $_view_ruta_img;
        $param["_view_ruta_js"]     = $_view_ruta_js;
        $param["_view_ruta_css"]    = $_view_ruta_css;

        //variables constantes
        $param["APP_SLOGAN"]        = APP_SLOGAN;
        $param["APP_COMPANY"]       = APP_COMPANY;
        $param["APP_MAILTO"]        = APP_MAILTO;
        $param["BASE_URL"]          = BASE_URL;
        $param["ROOT"]              = ROOT;
        $param["APP_PATH"]          = APP_PATH;
        $param["APP_NAME"]          = APP_NAME;
        $param["APP_FOLDER_NAME"]   = APP_FOLDER_NAME;

        //para fechas y tiempo
        $param["year"]   = date("Y");
        $param["month"]   = date("m");
        $param["day"]   = date("d");


        $param["_layout"]           = $this->_layout;
        $param["_path_layout"]      = $_path_layout;

        $param = array_merge($param,$this->_paramForViewTwig);

        try{
            if($ajax != false)
            {
                $loader = new Twig_Loader_Filesystem($_ruta_view);
                $this->_objTwig->setLoader($loader);
                echo $this->_objTwig->render($vista.'.twig', $param);
                exit;
            }

            $loader = new Twig_Loader_Filesystem(array($_path_layout,$_ruta_view,$_ruta_nav));
            $this->_objTwig->setLoader($loader);

            $template = $this->_objTwig->loadTemplate($vista.".twig");
            echo $template->render($param);
            exit;
        }
        catch ( Exception $e)
        {
            echo $e;
            throw new Exception("Error cargando la vista indicada");
        }
    }

    /**
     * Función para renderizar la vista
     * @param $vista
     * @param bool $ajax
     * @throws Exception
     */
    public function renderizar($vista, $ajax = false)
    {
        if(DEFAULT_COMPILER == "Smarty")
        {
            $this->renderSmarty($vista, $ajax);
        }
        else
        {
            $this->renderTwig($vista, $ajax);
        }
    }


    /**
     * Función para agregar ficheros js a la vista que se va a compilar
     * @param array $js
     * @throws Exception
     */
    public function setJs(array $js)
    {                  
        $pathJsView = BASE_URL . 'app/'. APP_FOLDER_NAME .'/views/' . $this->_controlador . '/js/';
        $pathJsLayout = BASE_URL . 'app/'. APP_FOLDER_NAME .'/views/layout/' . $this->_layout . '/js/';

        $pcv = ROOT . 'app'. DS . APP_FOLDER_NAME . DS . 'views'. DS . $this->_controlador . DS .'js'. DS;
        $pcl = ROOT . 'app'. DS . APP_FOLDER_NAME . DS . 'views'. DS . 'layout'. DS . $this->_layout . DS .'js'. DS;

        if(is_array($js) && count($js)){
            for($i=0; $i < count($js); $i++){
                if(file_exists($pcv . $js[$i] . '.js'))
                    $this->_js[] = $pathJsView . $js[$i] . '.js';
                elseif(file_exists($pcl . $js[$i] . '.js'))
                    $this->_js[] = $pathJsLayout . $js[$i] . '.js';
            }
        } else {            
            throw new Exception('Error de js');
        }
    }

    /**
     * Función para agregar ficheros css a la vista que se va a compilar
     * @param array $css
     * @throws Exception
     */
    public function setCss(array $css)
    {
        $pathCssView = BASE_URL . 'app/'. APP_FOLDER_NAME .'/views/' . $this->_controlador . '/css/';
        $pathCssLayout = BASE_URL . 'app/'. APP_FOLDER_NAME .'/views/layout/' . $this->_layout . '/css/';

        $pcv = ROOT . 'app'. DS . APP_FOLDER_NAME . DS . 'views'. DS . $this->_controlador . DS .'css'. DS;
        $pcl = ROOT . 'app'. DS . APP_FOLDER_NAME . DS . 'views'. DS . 'layout'. DS . $this->_layout . DS .'css'. DS;

        if(is_array($css) && count($css)){
            for($i=0; $i < count($css); $i++){
                if(file_exists($pcv . $css[$i] . '.css'))
                {
                    $this->_css[] = $pathCssView . $css[$i] . '.css';
                }
                else{
                    if(file_exists($pcl . $css[$i] . '.css'))
                    {
                        $this->_css[] = $pathCssLayout . $css[$i] . '.css';
                    }
                }
            }
        } else {
            throw new Exception('Error de css');
        }
    }

    /**
     * Función para agregar css con un camino personalisado
     * @param $css
     */
    public function setCssCustomPath($css)
    {
        $this->_css[] = $css;        
    }

    /**
     * Función para obtener el Layaout activo
     * @return mixed
     */
    public function getLayout()
    {
        return $this->_layout;
    }

    /**
     * Función para setear un Layaout
     * @param $layout
     */
    public function setLayout($layout)
    {
        $this->_layout = $layout;
    }

    public function getTwigObj()
    {
        return $this->_objTwig;
    }

    /**
     * Función para cargar los helpers a las vistas
     * @param array $helper
     * @throws Exception
     */
    public function loadHelper(array $helper)
    {
        $class = get_declared_classes();
        
        if(is_array($helper) && count($helper)){
           for($i=0; $i < count($helper); $i++){
               if(!in_array($helper[$i],$class)){
                    $objh = new $helper[$i];
                    $this->assign($helper[$i],$objh);
               }
            } 
        }
        else {
            throw new Exception('Error cargando el helper: '.$helper);
        }
    }

    public function getPathView()
    {
        $_ruta_view = ROOT . 'app' . DS . APP_FOLDER_NAME . DS  . 'views' . DS . $this->_controlador . DS;
        return $_ruta_view;
    }

}

?>