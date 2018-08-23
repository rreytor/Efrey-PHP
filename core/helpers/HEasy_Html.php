<?php

class HEasy_Html {

    /**
     * Genera una etiqueta link
     * @param rel del link (stylesheet, media, etc..)     
     * @param type de link (print, text/css, etc..)
     * @param direccion del fichero a cargar  
     * @example $HEasy_Html->tag_link("../css/style.css","stylesheet","text/css")                 
     */
    public function tag_link($href,$rel=null,$type=null,$param=null) 
    {
        if($param != null)
        {
            $par = null;
            foreach ($param as $item) 
            {
                $vals = explode(":", $item);
                $key = $vals[0];
                $val = $vals[1];

                $par .= $key . "='$val' ";
            }    
        }
        else
            $par = "";
        
        if($rel == null)
            $rel = "stylesheet";
        
        if($type == null)
            $type = "text/css";
        
        echo "<link rel=\"$rel\" type=\"$type\" href=\"$href\" $par >";
    }

    /**
     * Genera una etiqueta script
     * @param rel del link      
     * @param type de link (print, text/css, etc..)
     * @param direccion del fichero a cargar  
     * @example $HEasy_Html->script_link("{$_ruta_js}jquery-1.7.1.min.js","text/javascript")                 
     */
    public function script_link($src,$type="text/javascript") 
    {        
        echo "<script src=\"$src\" type=\"$type\"></script>";                
    }
    
    /**
     * Genera una etiqueta ancho <a></a> 
     * @param Dirección del vinculo      
     * @param Texto que mostrará el vinculo
     * @param Paramentros a pasar                    
     * @example $HEasy_Html->link("http://obeweb.elecij.une.cu","ELECIJ",array("title:Provando anchor");            
     */
    public function link($href, $text, $param = null) 
    {
        $a = "<a href=\"{$href}\"";
        if($param != null)
            foreach ($param as $item) 
            {
                $vals = explode(":", $item);
                $key = $vals[0];
                $val = $vals[1];

                $a .= $key . "='$val' ";
            }
        /*
        foreach ($param as $key => $val) {
            $a .= $key . "='$val' ";
        }*/
        $a .= ">$text</a>";
        echo $a;
    }
    
    /**
     * Genera una etiqueta ancho para funciones javascript dado un evento
     * @param Evento 
     * @param Texto a mostrar en el enlace      
     * @param Funcion a ejecutar cuando se desencadene el evento
     * @param Paramentros para la función                    
     * @example $HEasy_Html->link_event_js("onclik","Enviar mensaje","send_msg","user,'Provando anchor'");            
     */
    public function link_event_js($event, $text, $funct, $param = null) 
    {
        $a = "<a href=\"javascript:;\" $event=\"$funct($param)\">$text</a>";
        echo $a;
    }
   
    /**
     * Genera una etiqueta img <img />
     * @param Direccion de la imagen
     * @param Texto que mostrara en caso alternativo y de titulo
     * @param paramentros a pasar                    
     * @example $HEasy_Html->img("/images/test.png","Titulo alternativo",array("width:50","heigth:50"));            
     */
    public function img($src, $title=null,$alt=null, $param = null) {
        $img = "<img src='$src' title='$title' alt='$alt'";

        if($param != null)
            foreach ($param as $item) 
            {
                $vals = explode(":", $item);
                $key = $vals[0];
                $val = $vals[1];

                $img .= $key . "='$val'";
            }
        $img .= "/>";
        echo $img;
    }

    /**
     * Genera una etiqueta br <br/>
     * @param numero de br a escribir                   
     * @example $HEasy_Html->br(2));            
     */
    public function br($num = 1) 
    {
        $br = "";
        if($num > 1)
        {
            $i = 1;
            while ($i <= $num)
            {
                $br .= "<br/>";
                $i++;
            }
        }
        else
            $br = "<br/>";        
        
        echo $br;
    }

    /**
     * Genera una etiqueta header
     * @param Número de header
     * @param Texto a mostrar
     * @param Id
     * @param Estilo
     * @example $HEasy_Html->H(2,"htitulo","title"));            
     */
    public function H($num = 1,$text,$id="",$class="") 
    {
        if($class != "")
            $class = "class='$class'";
        if($id != "")
            $id = "id='$id'";
            
        $h = "<h$num $id $class>$text</h$num>";        
        echo $h;
    }
    
    /**
     * Genera un combobox
     * @param type $name nombre e id del combobox
     * @param array $info un array asociativo donde el id del array es el value del combo y el values del array es la info a mostrar en el combo
     * @param array $events al igual que $info pero con los eventos
     */
    public function combobox($name, array $info,$events = NULL,$style = null,$show_value = false,$firstBlanck = false)
    {
       $options = null; 
       if(count($info) > 0)
        {
            if($firstBlanck == true)
                $options .= "<option></option>";
            
            foreach($info as $item)
            {
                if($show_value != false)
                    $options .= "<option value='".$item[0]."'>".$item[0]."-".  htmlentities(utf8_encode($item[1]))."</option>";
                else
                    $options .= "<option value='".$item[0]."'>".htmlentities(utf8_encode($item[1]))."</option>";
            }
        }
        
        $st = (($style != null)?'class="'.$style.'"':"");
        
       if($events != null)
        {
            $events = explode(":", $events);
            $strevents = $events[0]."='".$events[1]."'";
            
            $cbx = "<select $st name='$name' id='$name' $strevents >$options</select>";
        }
        else
        {
            $cbx = "<select $st name='$name' id='$name'>$options</select>";
        }
        
        return $cbx;
    }

    

}

?>