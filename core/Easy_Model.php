<?php
/**
 * @desc        Class Easy_Model, se definen las funciones genererales para los modelos que heredan de ella
 * @author:     Reynier Reytor Vega
 * @copyright   Easycubasoft 10/06/2015
 */

class Easy_Model
{
    protected $_db;
    protected $_table;
    protected $_connName;


    public function __construct($table = null,$conn = null) 
    {
        if($table != null)
        {
            $this->setTable($table);
        }
        
        if($conn != null)
        {
            $this->_connName = $conn;
            $this->setConection($conn);
        }
        else
        {
            $this->_connName = "default";
            $db = new Easy_Database();
            $this->_db = $db->getConn();
            $this->_db->debug=false;
        }
    }

    /**
     * @desc Función para activar la conexión al servidor de base de datos deseada
     * @param $db, nombre de la conección, estas se definen en el fichero "config/App_Config.php".
     */
    public function setConection($db)
    {
        $this->_connName = $db;
        $db = new Easy_Database($db);
        $this->_db = $db->getConn();
    }
    
    public function setTable($table)
    {
        $this->_table = $table;
    }
    
    public function getTable()
    {
        return $this->_table;
    }
    /**
    * @desc funcion para generar la query para insertar o actualizar  
    * @param tipo de query 1 para insert 0 para update 
    * @param datos a insertar o actualizar ej: campo=valor|campo1=valor1
    * @param filtro para el update
    * @param tabla a tratar
    * @return string con el query formado
    */
    function genQuerySqlInsOrUp($tip,$dat,$fil=null,$tab=null)
    {
            if($tab == null)
            {
                $tab=  $this->_table;
            }
            
            $a="";
            $b="";
            if ($tip==1){
                $dat = explode('|', $dat);
                $c = count($dat);
                for ($d = 0; $d < $c; $d++) 
                {
                    if (strlen($dat[$d])>0) 
                    {
                        $pos=abs(strpos($dat[$d],"="));
                        $a=$a.($d==0?"":",").substr($dat[$d],0,$pos);
                        $s=(strlen($dat[$d])>0?"":"'");
                        $b=$b.($d==0?"":",").$s.substr($dat[$d],$pos+1,strlen($dat[$d])).$s;
                    }
                }
                $dat="(".$a.")"." values(".$b.");";
            }else{
                $dat = explode('|', $dat);
                $c = count($dat);
                for ($d = 0; $d < $c; $d++) {
                    if (strlen($dat[$d])>0) {
                        $b=$b.($d==0?"":",").$dat[$d];
                    }
                }
                $dat="set ".$b;
            }
            
            $pos = strpos($fil, "where");
            if($fil != null and $pos === false)
                $fil = "where ".$fil;
            
            $q=($tip==1?"insert into ":"update ").$tab." ".$dat." ".$fil;
            return $q;
      }
    
    /**
    * @desc Funcion para retornar todos los datos de una tabla 
    * @param string $filter Obtener los que cumplan con el filtro (opcional)   
    * @param string $order ordenar los resultados   
    * @param bool $returnA true para retornar los resultados en un arreglo, true por defecto
    * @return un adorecordset con los datos de la tabla o un array si $returnA = true
    */
    function getAll($filter = null,$order = null, $returnA=true)
    {           
        if($filter != null)
        {
            if($order != null)
            {
               $query = "Select * from $this->_table where $filter order by $order"; 
            }
            else
            {
              $query = "Select * from $this->_table where $filter";  
            }
        }
        else
        {
            if($order != null)
            {
               $query = "Select * from $this->_table order by $order"; 
            }     
            else
            {
               $query = "Select * from $this->_table"; 
            }
        }

        $rs = $this->_db->Execute($query);

       if($returnA == false) 
            return $rs;
       else
           return $this->adoRstoArray ($rs);
    }
    
    /**
    * Funcion para obtener el primer elemento de una consulta    
    * @param string $filter Obtener los que cumplan con el filtro
     * @param bool $returnA true para retornar los resultados en un arreglo
    * @return un adorecordset con los datos de la tabla o un array si $returnA = true
    */
    public function getOne($filter, $returnA=true)
    {
        $rs = $this->_db->Execute("Select * from $this->_table where $filter");

        if($returnA == false)
            return $rs;        
        else
        {
            $arrrs = $this->adoRstoArray($rs);

            if(count($arrrs) > 0)
            {
                return $arrrs[0];
            }
            else
                return false;
        }
    }
    
    /**
     * @desc Funcion para obtener la cantidad de elementos
     * @param type $filter Obtener los que cumplan con el filtro (opcional)
     * @return type
     */
    function getAmount($filter = null)
    {
        if($filter != null)
        {
            $query = "Select count(*) as count from $this->_table where $filter";
            $rs = $this->_db->Execute($query);

            if(!is_nan($rs->fields('count')))
                return $rs->fields('count');
            else
                return 0;
        }
        else
        {
            $query = "Select count(*) as count From $this->_table";
            $rs = $this->_db->Execute($query);

            if(!is_nan($rs->fields('count')))
                return $rs->fields('count');
            else
                return 0;

            //return $rs->fields(0);
        }
    }
    
    /**
     * @desc Funcion para optener el top de elementos
     * @param type $top cantidad de elementos
     * @param type $filter filtro a cumplir
     * @param bool $returnA true para retornar los resultados en un arreglo
     * @return adorecorset 
     */
    function getTop($top = 1,$filter = null,$order = null,$returnA=true)
    {
        $easy_db_data = Easy_Session::get('easy_db_data');
        $db_driver = $easy_db_data[$this->_connName]['db_driver'];


        if($filter != null)
        {
            if($db_driver == "mysql")
            {
                if($order != null)
                    $query = "Select * FROM $this->_table  where $filter order by $order LIMIT $top";
                else
                    $query = "Select * FROM $this->_table  where $filter LIMIT $top";

                $rs = $this->_db->Execute($query);
            }
            else
            {
                $query = "Select TOP $top * FROM $this->_table where $filter order by $order";
                $rs = $this->_db->Execute($query);
            }
        }
        else
        {
            if($db_driver == "mysql")
            {
                if($order != null)
                    $query = "Select * FROM $this->_table order by $order LIMIT $top ";
                else
                    $query = "Select * FROM $this->_table LIMIT $top ";

                $rs = $this->_db->Execute($query);
            }
            else
            {
                $query = "Select TOP $top * FROM $this->_table";
                $rs = $this->_db->Execute($query);
            }
        }
        
        if($returnA==false)
            return $rs;
        else
            return $this->adoRstoArray($rs);
    }
    
    /**
     * Funcion para ejecutar una consulta literalmente
     * @param type $query
     * @param bool $returnA true para retornar los resultados en un arreglo
     * @return type
     */
    function ExecuteQuery($query, $returnA=true)
    {
        if($returnA==false)
            return $this->_db->Execute($query);
        else
        {
            $rs = $this->_db->Execute($query);
            //var_dump($rs);
            return $this->adoRstoArray($rs);
        }
    }
    
    /**
     * Funcion para obtener la informacion de uno o varios campos
     * @param type $table
     * @param array $fields
     * @param bool $returnA true para retornar los resultados en un arreglo
     * @return resultado de la consulta (adorecordset)
     */
    public function getInfoFields(array $fields, $returnA=true)
    {      
        $i=0;
        $str_fields = null;
        if(count($fields) > 0)
        {
          foreach($fields as $item)
          {
              if($i > count($fields))
                $str_fields .= $item.",";
              else 
                $str_fields .= $item;

              $i++; 
          }
        }
        else
        {
            $str_fields = '*'; 
        }
        
        $rs = $this->_db->Execute("Select $str_fields from $this->_table");
        
        if($returnA==false)        
            return $rs;
        else
            return $this->adoRstoArray($rs);
    }
    
    /**
     * Funcion para ejecutar un procedimiento almacenado
     * @param String nombre del procedimiento almacenado
     * @param array parametros a pasar al procedimiento
     * @param bool $returnA true para retornar los resultados en un arreglo
     * @return adorecordset
     */
    
    function ExecuteStoreProcedureMsSQL($sp,array $param=array(), $returnA=true)
    { 
        $stmt = $this->_db->PrepareSP($sp); 
        if(count($param) > 0)
        {
            foreach($param as $key => $val)
            {
               $this->_db->OutParameter($stmt,$val,$key); 
            }
        }
        
        $rs = $this->_db->Execute($stmt); 
        
        if($returnA==false)        
            return $rs;
        else
            return $this->adoRstoArray($rs);
    }

    /**
     * Funcion para ejecutar un procedimiento almacenado
     * @param String nombre del procedimiento almacenado
     * @param array parametros a pasar al procedimiento
     * @param bool $returnA true para retornar los resultados en un arreglo
     * @return adorecordset
     */

    function ExecuteStoreProcedureMySQL($sp, $returnA=true)
    {
        $rs = $this->_db->Execute("call $sp");

        if($returnA==false)
            return $rs;
        else
            return $this->adoRstoArray($rs);
    }

    /**
     * Funcion para eliminar
     * @param String nombre del procedimiento almacenado
     * @param array parametros a pasar al procedimiento
     * @return adorecordset
     */
    
    function deleteTupla($filter=null)
    { 
        if($filter != null)
            $query = "DELETE FROM $this->_table where $filter";            
        else
            $query = "DELETE FROM $this->_table";            
        
        $rs = $this->_db->Execute($query); 
        return $rs;
    }

    /**
     * @desc función para convertir de AdoRecorset a un array.
     * @param $rs
     *
     * @return array
     */
    public function adoRstoArray($rs)
    {
        $data = array();
        if($rs->RecordCount() > 0)
            foreach($rs as $item)
            {
                $data[] = $item;
            }
        return $data;
    }
}

?>
