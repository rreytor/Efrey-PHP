<?php
/**
 * Description of indexController
 *
 * @author rreytor
 */
class indexController extends Easy_Controller
{
    function index() {
        $this->assign("_title","EFREY-PHP");
        $this->assign("title","Crear una aplicación");

        $this->setCss("style");

        if(APP_ENVIRONMENT == "P")
        {
            new Easy_Error(" UUPS!!! estás tratando de acceder a una aplicación solo para el entorno de desarrollo","error");
            exit;
        }

        $arrApp = array();
        $gest_dir = opendir(ROOT.DS."app");
        while (false !== ($archivo = readdir($gest_dir))) {
            if(is_dir(ROOT.DS."app".DS.$archivo) and $archivo != "." and $archivo != "..")
            {
                $arrApp[] = array("dir"=>$archivo,"date"=>date("d/m/Y",filectime(ROOT.DS."app".DS.$archivo)));
            }
        }

        if(isset($_SERVER['HTTP_MOD_REWRITE']))
            $this->assign("mod_rewrite","ACTIVADO");
        else
            $this->assign("mod_rewrite","DESACTIVADO");

        $this->assign("listApp",$arrApp);




        $this->renderizar("index");
    }


}
