<?php

/*
 * Esta clase cuenta con funciones de apollo para el trabajo con fechas.
 */

/**
 * Description of Easy_Date
 *
 * @author rreytor
 */
class HEasy_Date {   
    
    /**
     * Función para Obtener un año
     * @param $year para sumar o restar x cantidad de años al actual null para obtener el actual
     */
    public function getYear($y = null) {
        if($y != null)
            return date("Y") + $y;
        else
            return date("Y");
    }   
    
     /**
     * Función para Obtener combo con una lista de años
     * @param $year para sumar o restar x cantidad de años al actual null para obtener el actual
     */
    public function getRangeYearCombo($name,$yb = null, $ye = null, $class="edtSelect",$selec=null) {
        
        if($yb == null)
            {$yb = date("Y") - 10;} 
        else
            {$yb = date("Y") - $yb;}                                          
        if($ye == null)
            {$ye = date("Y"); }
        else
            {$ye = date("Y") + $ye; }
            
            
        if($selec == null)
            $selec = date('Y');    
            
        $combo = '<select id="'.$name.'" name="'.$name.'" class="'.$class.'">';
                
        $arry = array();
        for($i = $yb; $i <= $ye;$i++)
        {
           if($i == $selec) 
                $select = "selected='selected'";
           else
                $select = "";
                
           $combo .= '<option value="'.$i.'" '.$select.'>'.$i.'</option>';
        }
        
        $combo .= '</select>'; 
        return $combo;
    }
     /**
     * Función para Obtener un combo con la lista de meses
     */
    public function getMothCombo($name,$short = false, $class="edtSelect",$selec=null) {
            
        $combo = '<select id="'.$name.'" name="'.$name.'" class="'.$class.'">';

        if($selec == null)
            $selec = date('n');
        
        $arry = array();
        for($i = 1;$i<=12;$i++)
        {
            if(!$short)
            {
                $nm = $this->getNameMonth($i);
            }
            else
            {
                $nm = $this->getShortNameMonth($i);
            }
            
            if($selec == $i)
                $select = "Selected=\"\"";
            else
                $select = "";
            
            $combo .= '<option value="'.$i.'" '.$select.'>'.$nm.'</option>';
        }            
        $combo .= '</select>'; 
        return $combo;
    }
     /**
     * Función para Obtener un combo con la dias del meses
     */
    public function getDayCombo($name,$class="edtSelect",$selec=null) {
            
        $combo = '<select id="'.$name.'" name="'.$name.'" class="'.$class.'">';       
        
        if($selec == null)
            $selec = date('j');
        
        $arry = array();
        for($i = 1;$i<=31;$i++)
        {
            if($selec == $i)
                $chek = "selected=\"\"";
            else
                $chek = "";
            
            $combo .= '<option value="'.$i.'" '.$chek.'>'.$i.'</option>';
        }            
        $combo .= '</select>'; 
        return $combo;
    }
    /**
     * Función para obtener el mes
     */
    public function getMonth() {
        return date("m");
    }
    
    /**
     * Funcion para obtener la hora y fecha actual
     */
    public function getNow()
    {
        return date('d-m-Y H:i:s');
    }
    
    /**
     * Funcion para obtener la marca de tiempo
     */
    public function getTime()
    {
        return time();
    }
        

    /**
     * Para obtener el nombre de un mes dado el numero     
     * @param int $m   month     
     * @example $this->getNameMonth(3)
     * @return String Name for month or false en case wrong month number
     */
    public function getNameMonth($m) {
               
        $m = $m + 0;
        if($m >= 1 and $m <= 12) {
            $month = array( "1" => "Enero",
                            "2" => "Febrero",
                            "3" => "Marzo",
                            "4" => "Abril",
                            "5" => "Mayo",
                            "6" => "Junio",
                            "7" => "Julio",
                            "8" => "Agosto",
                            "9" => "Septiembre",
                            "10" => "Octubre",
                            "11" => "Noviembre",
                            "12" => "Diciembre");       
            return $month[$m];            
        }
        else {
            return false;
        }
      
    }
    
    /**
     * Para obtener el nombre de un mes dado el numero     
     * @param int $m   month     
     * @example $this->getNameMonth(3)
     * @return String Name for month or false en case wrong month number
     */
    public function getShortNameMonth($m) {
               
        if($m >= 1 and $m <= 12) {
            $month = array( "1" => "Ene",
                            "2" => "Feb",
                            "3" => "Mar",
                            "4" => "Abr",
                            "5" => "May",
                            "6" => "Jun",
                            "7" => "Jul",
                            "8" => "Ago",
                            "9" => "Sep",
                            "10" => "Oct",
                            "11" => "Nov",
                            "12" => "Dic");       
            return $month[$m];            
        }
        else {
            return false;
        }
      
    }
    /**
     * Para obtener el nombre de un dia dado el numero del dia en la semana
     * @param int $m   dia
     * @example $this->getDayName(2) = "Martes"
     * @return String Name for month or false en case wrong month number
     */
    public function getDayName($d) {

        if($d >= 0 and $d <= 6) {
            $day = array( "0" => "Domingo",
                            "1" => "Lunes",
                            "2" => "Martes",
                            "3" => "miercoles",
                            "4" => "Jueves",
                            "5" => "Viernes",
                            "6" => "Sabado");
            return $day[$d];
        }
        else {
            return false;
        }

    }
    
    /**
     * Return cant of day for a month
     * @param $m month
     * @param $y by default null, if null take actual year
     * @example $this->getCantDayInMonth(2);
     * @example $this->getCantDayInMonth(2,'2013');
     * @return cant day or false en case wrong month number
     */
    public function getCantDayInMonth($m, $y = null){
         if ($y == null) {
            $y = $this->getYear();
        }    
        
        $f = cal_days_in_month(CAL_GREGORIAN, 2, $y);
        $cantDM = array(31, $f, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        
        if($m >= 1 and $m <= 12) {
            return $cantDM[$m-1];
        }
        else {
            return false;
        }
    }

    /**
     * Return day of week
     * @param $d day
     * @param $m month by default null, if null take actual month
     * @param $y by default null, if null take actual year
     * @example $this->getCantDayInMonth(2);
     * @example $this->getCantDayInMonth(5,2,'2013');
     * @return Day of the week, 0=Sunday.....7=Saturday
     */
    public function getDayofWeek($d, $m = null, $y=null){
         if($y == null) {
            $y = $this->getYear();
         }    
         if($m == null) {
            $m = $this->getMonth();
         }    
        
         return jddayofweek ( cal_to_jd(CAL_GREGORIAN, $m,$d,$y));
    }
    
    /**
     * Compara dos fechas
     * @param type $date1
     * @param type $date2
     * @return int  0 (fechas =); 1 (fecha1 > fecha2); 2 (fecha1<fecha2) 
     */
    public function compareDate($date1,$date2)
    {

        $d1 = strtotime($date1);
        $d2 = strtotime($date2);

        $dif = $d1 - $d2;
        switch ($dif)
        {
            case 0:
                return 0;
              break;
            case $dif < 0:
                return 2;
              break;
            case $dif > 0:
                return 1;
              break;
            
        }
    }
    /**
     * Compara dos tiempos
     * @param type $time1
     * @param type $time2
     * @return int  0 (times =); 1 (t1 > t2); 2 (t1<t2) 
     */
    public function compareTime($t1,$t2)
    {
        $d1 = strtotime($t1);
        $d2 = strtotime($t2);
         
        $dif = $d1 - $d2;
        
        switch ($dif)
        {
            case 0:
                return 0;
              break;
            case $dif < 0:
                return 2;
              break;
            case $dif > 0:
                return 1;
              break;
            
        }
    }
	
	/**
     * Retorna la cantidad de dias entre dos fechas, redondeados por defecto
     * @param $d fecha 1
     * @param $d1 fecha 2
     * @return entero, cantidad de dia
     *
     */
    function cantDayEntreFecha($d,$d1)
    {
        $d = strtotime($d);
        $d1 = strtotime($d1);

        $d = $d - $d1;

        return floor($d/86400);
    }

    public function restarDate($b,$e)
    {
        $d1 = strtotime($b);
        $d2 = strtotime($e);
        
        $d = $d1 - $d2;
        
        $dd = date('i', $d);
        
        return $dd;

    }

    /**
     * Funcion que convierte de segundos a Horas:Minutos:Segundos
     * @param Segundos
     * @return String H:M:S
     */
    public function segToHour($seg)
    {
        $h = explode(".", $seg/3600);
        $h = $h[0];
        $res = $seg - $h*3600;
        
        $m = explode(".",($res/60));
        $m = $m[0];
                
        $res = $res - $m*60;
        
        return $h.":".$m.":".$res;
    }

    /**
     * Funcion que convierte de minutos a Horas:Minutos
     * @param Segundos
     * @return String H:M
     */
    public function minToHour($min)
    {
        $h = explode(".", $min/60);
        $h = $h[0];
        $m = $min - $h*60;

        return array("hour"=>$h,"minute"=>$m);
    }

    /**
     * Funcion que determina la fecha de ayer
     * @param formato de la fecha por defecto (d-m-Y)
     * @return date "d-m-Y"
     */
    public function ayer($format = "d-m-Y")
    {
        $hoy = time();
        $ayer = $hoy - 86000;

        return date($format,$ayer);
    }

    /**
     * Funcion para retornas un arreglo con las fechas entre dos fechas dadas
     * @param fecha inicio
     * @param fecha fin
     * @return array de fechas
     */
    function getDateInterval($fi,$fe)
    {
        if(strpos($fi,"/") != false)
        {
            $fi = explode("/",$fi);
            $fe = explode("/",$fe);
        }
        elseif(strpos($fi,"-") != false)
        {
            $fi = explode("-",$fi);
            $fe = explode("-",$fe);
        }

        $fi = $fi[2]."/".$fi[1]."/".$fi[0];
        $fe = $fe[2]."/".$fe[1]."/".$fe[0];

        $timefi = strtotime($fi);
        $timefe = strtotime($fe);

        $arr = array();
        $time = $timefi;
        while($time <= $timefe)
        {
            $arr[] = date("d/m/Y",$time);
            $time += 86400;
        }

        return $arr;
    }

}

?>