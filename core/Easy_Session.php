<?php
    /**
     * @desc        Class Easy_Session, se encarga del manejo de las variables de session
     * @author:     Reynier Reytor Vega
     * @copyright   Easycubasoft 10/06/2015
     */


    class Easy_Session
  {
      /**
      * Inicializa la utilizacion de sessiones
      */
      public static function start()
      {
          session_start();          
      }
      
      /**
      * para registrar una session
      * 
      * @param mixed $var es un array
      */
      public static function register(array $var)
      {
          if(is_array($var))
          {   
              foreach($var as $key => $value)
              {
                  $_SESSION[$key] = $value;
              }
          }   
      }
      
      /**
      * para eleminar una variable de session
      * 
      * @param mixed $var
      * @example $var = array('login','user') o $var = 'login'
      */
      public static function unregister($var = false)
      {
          if($var)
          {
              if(is_array($var))
              {
                  foreach($var as $key)
                  {
                      if(isset($_SESSION[$key]))
                        {unset($_SESSION[$key]);}
                  }
              }
              else
              {
                  if(isset($_SESSION[$var]))
                   {unset($_SESSION[$var]);}
              }
          }
          else
          {
              self::destroy();
          }
      }
      
      /**
      * para destruir todas las variables de la session activa
      */
      public static function destroy()
      {
          session_destroy();
          session_unset();
      }
      
      /**
      * para obtener la informacion de una variable
      * 
      * @param mixed $var
      * @return mixed
      */
      public static function get($var)
      {
          if(isset($_SESSION[$var]))
          {
              return $_SESSION[$var];
          }
          else
              return false;
      }
      /**
      * para chequear una varianble
      * 
      * @param mixed $var
      * @return mixed
      */
      public static function checkSession($var)
      {
          if(isset($_SESSION[$var]) == true)
          {
              return true;
          }
          else
              return false;
      }
      
      /**
      * chequear el tiempo de actividad del usuario registrado, de estar vencido lo saca del sistema 
      */
      public static function tiempo($url)
      {
          if(!Easy_Session::get('time') || !defined('SESSION_TIME')){
            throw new Exception('No se ha definido el tiempo de sesion'); 
          }

          if(SESSION_TIME == 0){
                return;
          }

          if(time() - Easy_Session::get('time') > (SESSION_TIME * 60))
          {
              Easy_Session::destroy();
              header('Location:' . BASE_URL . $url);
          } 
          else
          {
              Easy_Session::register(array('time'=> time()));
          }
      } 
      
  }
?>