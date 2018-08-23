<?php
/**
 * @desc        Class Easy_Database, se encarga de generar los objetos de coneccion a las bases de datos.
 * @author:     Reynier Reytor Vega
 * @copyright   Easycubasoft 10/06/2015
 */

class Easy_Database
{
    private $_conn;
    private $host;
    private $user;
    private $pass;
    private $db_name;
    private $dbchar;
    private $db_driver;
    
    /**
    * @desc constructor de la clase 
    * @param identificador de la base de datos establecido en el fichero Config.php  $easy_db_data['identificador']['parametro']
    */
    public function __construct($db = "default") 
    {

        if(is_readable(APP_PATH."adodb/adodb.inc.php"))
        {
            require_once APP_PATH."adodb/adodb-errorhandler.inc.php";
            //require_once APP_PATH."adodb/adodb-exceptions.inc.php";
            require_once APP_PATH."adodb/adodb.inc.php";

            //$ADODB_FETCH_MODE = ADODB_FETCH_BOTH;
            $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;

        }    
        else
        {
            throw new Exception("No se encuentra la biblioteca ADODB, verifique en core/adodb");
            exit;
        }
        
        $easy_db_data = Easy_Session::get('easy_db_data');   
        
        $this->host = $easy_db_data[$db]['host'];              
        $this->user = $easy_db_data[$db]['user'];              
        $this->pass = $easy_db_data[$db]['pass'];              
        $this->db_name = $easy_db_data[$db]['db_name'];              
        $this->dbchar = $easy_db_data[$db]['dbchar'];              
        $this->db_driver = $easy_db_data[$db]['db_driver'];              
                    
    }
    
    /**
    * @desc crea una coneccion a una base de datos
    */
    public function conect()
    {                           
        switch ($this->db_driver) 
        {
            //se crea el objeto de coneccion para mysql
            case 'mysql':                 
                 $db = $this->connMySQL(); 
             break;
             //se crea el objeto de coneccion para sqlserver
            case 'mssql':                 
                 $db = $this->connSQL();
             break;
            case 'odbc_mssql':
                 $db = $this->connODBC_SQL();
             break;
            case 'postgres':
                 $db = $this->connPostgreSQL();
             break;
            case 'sqlite':
                 $db = $this->connSQLite();
             break;
         }

         $this->_conn = $db;
    }
    
    /**
    * @desc retorna el objeto coneccion y si no existe lo crea
    */
    public function getConn()
    {
        if($this->_conn == null)
        {
           $this->conect();
           return $this->_conn;
        }
        else
            return $this->_conn;
    }    
    
    
    /**
    * @desc function para conectarce a una base de datos SQLSERVER
    */
     function connSQL()
     {   
        try
        {   
            $db = NewADOConnection('mssql');
            $db->Connect($this->host,$this->user,$this->pass,$this->db_name);
        }
        catch (exception $e)
        {             
           return false;
        }  
         return $db;

/*
          $db = &NewADOConnection('mssql');
          $db->Connect($this->host,$this->user,$this->pass,$this->db_name);
          $dsn = "Server=".$this->host.";Database=".$this->db_name."";
          $db->Connect($dsn,$this->user,$this->pass);
          $db->debug = false;
          return $db;*/
     }

    /**
     * @desc function para conectarce a una base de datos SQLSERVER mediante odbc
     */
    function connODBC_SQL()
     {
        try
        {
            $db = ADONewConnection('odbc_mssql');
            $dsn = "Driver={SQL Server};Server=$this->host;Database=$this->db_name";
            $db->Connect($dsn,$this->user,$this->pass);
        }
        catch (exception $e)
        {
           return false;
        }
         return $db;
     }
     
    /**
    * @desc function para conectarce a una base de datos MySQL
    */
     function connMySQL()
     {        
        try
        {   
            $db = &NewADOConnection('mysqli');
            $db->Connect($this->host,$this->user,$this->pass,$this->db_name);                
        } 
        catch (exception $e)
        {             
           return false;
        }  
         return $db;  
     }

    /**
    * @desc function para conectarce a una base de datos PostgreSQL
    */
     function connPostgreSQL()
     {
        try
        {
            $db = &ADONewConnection('postgres');
            $db->Connect($this->host,$this->user,$this->pass,$this->db_name);

        }
        catch (exception $e)
        {
           return false;
        }
         return $db;
     }

    /**
    * @desc function para conectarce a una base de datos SQLite
    */
     function connSQLite()
     {
        try
        {
            $db = &ADONewConnection('sqlite');
            $db->Connect($this->db_name,$this->user,$this->pass);
        }
        catch (exception $e)
        {
           return false;
        }
         return $db;
     }
}

?>
