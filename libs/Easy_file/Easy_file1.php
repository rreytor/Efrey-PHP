<?php
/**
* @desc Biblioteca desarrollada por Reynier Reytor Vega, la misma es para 
*       fasilitar el uso de fichero y toda la gestion de los mismo 
*/

class Easy_file
{
    private $path;
    private $name;

    /**
    * @desc Constructor de la clase easy_file
    * @param nombre del fichero
    * @param direccion del fichero respecto a la raiz del sitio
    */
    public function __construct($name,$path)
    {
        $this->name = $name;
        $this->path = $path;
    }
    
    /**
    * @desc funcion para generar un fichero y ponerlo en el camino indicado
    * @param informacion a escribir en el fichero
    * @param condicion para borra el fichero si existe true para borrar, true por defecto
    */
    public function genFile($info,$if_exists=true)
    {
        $name_file = $this->path.$this->name;
        //verificar si el fichero existe y si la condicion de borrado esta activa se borra el fichero
        if(file_exists($name_file))
        {
            if($if_exists == true)
            {
                unlink($name_file);                                 //se borrar el fechero
                $file = fopen($name_file,'w+');                     //se crea el fichero deseado
            }
            else
            {
                $file = fopen($name_file,'a+');                     //se abre el fichero deseado y se coloca el puntero al final
            }
        }  
        else
        {
            $file = fopen($name_file,'w+');                         //si no existe el fichero se crea
        }

        fwrite($file,$info);
        
        fclose($file);
    }
    
    /**
    * @desc funcion para retornar la informacion de un fichero    
    * @return arreglo con los datos del fichero linea a linea
    */
    public function getData()
    {
        $name_file = $this->path.$this->name;        
        if(file_exists($name_file) != false)
        {
            $info = file($name_file,FILE_SKIP_EMPTY_LINES);
            return $info;
        }
        else
            return false;
    } 
   
    /**
    * @desc Funcion para borra el fichero. 
    * @return un booleano
    */
    public function deleteFile()
    {
        $name_file = $this->path.$this->name;
        return unlink($name_file);
    }   
    
    /**
    * @desc Funcion para buscar dentro de un fichero
    * @return arreglo con el número de las lineas donde se encontro la cadena
    */
    public function searchInFile($stream)
    {
        $info = $this->getData();
        
        for($i =0;$i<count($info);$i++)
        {
            if(stripos($info[$i],$stream) !== false)
            {
                $line[] = $i;
            }
        }
       return $line;         
    }
    
    /**
    * @desc Funcion para obtener la ultima modificacion
    */
    function getLastModific()
    {
        $file = $this->path.$this->name;
        return filemtime($file);
    }
    
    
}
?>