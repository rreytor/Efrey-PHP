<?php

/**
 * @desc        Class Easy_Request, se controla la peticion y se obtiene el controller, la funcion y los parametros que se pasen por URL
 * @author:     Reynier Reytor Vega
 * @copyright   Easycubasoft 10/06/2015
 */


class Easy_Request
{
    private $_controlador;
    private $_metodo;
    private $_argumentos;
    private $_url;

    public function __construct() {
        if(isset($_GET['url'])){
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $this->_url = $url;

            $url = explode('/', $url);
            /*$url = array_filter($url);*/

            $this->_controlador = strtolower(array_shift($url));
            $this->_metodo = strtolower(array_shift($url));
            $this->_argumentos = $url;


        }       
        
        if(!$this->_controlador){
            $this->_controlador = DEFAULT_CONTROLLER;
        }
        
        if(!$this->_metodo){
            $this->_metodo = 'index';
        }
                        
        if(!isset($this->_argumentos)){
            $this->_argumentos = array();
        }
    }

    
    public function getControlador()
    {
        return $this->_controlador;
    }
    
    public function getMetodo()
    {
        return $this->_metodo;
    }
    
    public function getArgs()
    {
        return $this->_argumentos;
    }

    public function getUrl()
    {
        return $this->_url;
    }
}

?>
