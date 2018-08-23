<?php
/**
* @desc Biblioteca desarrollada por Reynier Reytor Vega, la misma es para 
*       fasilitar el uso de fichero y toda la gestión de los mismo
*/

class HEasy_File
{
    private $path;
    private $name;

    /**
    * @desc Constructor de la clase easy_file
    * @param nombre del fichero
    * @param direccion del fichero respecto a la raiz del sitio
    */
    public function __construct($name=null,$path="public")
    {
        $this->name = $name;
        $this->path = $path;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPath($path)
    {
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
            $info = file($name_file,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
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

    /**
     * Downloader
     *
     * @param $archivo
     *  path al archivo
     * @param $downloadfilename
     *  (null|string) el nombre que queres usar para el archivo que se va a descargar.
     *  (si no lo especificas usa el nombre actual del archivo)
     *
     * @return file stream
     */
    function download_file($downloadfilename = null)
    {
        $archivo = $this->path.$this->name;

        if (file_exists($archivo))
        {
            $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $downloadfilename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));

            /*ob_clean();
            flush();*/
            readfile($archivo);
            exit;
        }
        else
            echo "Error url";

    }
}
?>