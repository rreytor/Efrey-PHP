<?php
/**
 * Created by PhpStorm.
 * User: rreytor
 * Date: 22/06/2015
 * Time: 03:36 PM
 */

class crearController extends Easy_Controller{

    function index()
    {
        $this->assign("_title","EFREY-PHP :: Crear APP");
        $this->assign("title","Crear Aplicación");
        $this->setJs("script");
        $this->renderizar("crear");
    }


    function createApp()
    {
        $name = $this->getPostParam("name");
        $slogan = $this->getPostParam("slogan");
        $company = $this->getPostParam("company");
        $mailto = $this->getPostParam("mailto");
        $compiler = $this->getPostParam("compiler");
        $server = $this->getPostParam("server");
        $user = $this->getPostParam("user");
        $pass = $this->getPostParam("pass");
        $dbname = $this->getPostParam("dbname");
        $driver = $this->getPostParam("driver");


        $appPath = ROOT.DS."app".DS;

        if(!is_dir($appPath.$name))
        {
            //creo el direcorio de la app
            mkdir($appPath.$name);
            //cambio al directorio de la app
            chdir($appPath.$name);

            mkdir($appPath.$name.DS."config");
            mkdir($appPath.$name.DS."controllers");
            mkdir($appPath.$name.DS."models");
            mkdir($appPath.$name.DS."views");
            mkdir($appPath.$name.DS."views".DS."index");
            mkdir($appPath.$name.DS."views".DS."index".DS."css");
            mkdir($appPath.$name.DS."views".DS."index".DS."js");
            mkdir($appPath.$name.DS."views".DS."index".DS."img");
            mkdir($appPath.$name.DS."views".DS."layout");
            mkdir($appPath.$name.DS."views".DS."layout".DS."default");
            mkdir($appPath.$name.DS."views".DS."layout".DS."default".DS."css");
            mkdir($appPath.$name.DS."views".DS."layout".DS."default".DS."js");
            mkdir($appPath.$name.DS."views".DS."layout".DS."default".DS."img");
            mkdir($appPath.$name.DS."views".DS."layout".DS."menu");

            //creo el fichero index.html para evitar el acceso directo a los directorios
            $this->indexHtml("index.html",$appPath.$name.DS);
            $this->indexHtml("index.html",$appPath.$name.DS."config".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."controllers".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."models".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."index".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."index".DS."css".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."index".DS."js".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."index".DS."img".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."layout".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."layout".DS."default".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."layout".DS."default".DS."css".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."layout".DS."default".DS."js".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."layout".DS."default".DS."img".DS);
            $this->indexHtml("index.html",$appPath.$name.DS."views".DS."layout".DS."menu".DS);


            //crear fichero App_Config
            $configFile = new HEasy_File("App_Config.php",$appPath.$name.DS."config".DS);
            $infoFile = "<?php
    /**
    * @desc      Fichero de configuracion de la aplicación
    * @copyright Easycubasoft::Efrey-PHP ".date('d/m/Y')."
    */
    /*****************************************************************************************
                              DEFINICIÓN DE DATOS DE LA APLICACIÓN
    *****************************************************************************************/

    //template por defecto
    define('DEFAULT_LAYOUT', 'default');
    //motor de plantillas por defecto puede ser Smarty o Twig
    define('DEFAULT_COMPILER', '".$compiler."');


    /*****************************************************************************************
                             DEFINICION DE DATOS DE LA COMPAÑIA
    *****************************************************************************************/

    //titulo del sitio
    define('APP_NAME',      '".$name."');
    //slogan del sitio
    define('APP_SLOGAN',    '".$slogan."');
    //compañía
    define('APP_COMPANY',   '".$company."');
    //correo de la compañía
    define('APP_MAILTO',    'mailto:".$mailto."');

    /*****************************************************************************************
                            DEFINICIONES DE LAS CONECIONES A LA BASE DE DATOS
    *****************************************************************************************/

    \$easy_db_data = array();
    //serrvidor de base de datos
    \$easy_db_data['default']['host']        =   '".$server."';
    //usuario
    \$easy_db_data['default']['user']        =   '".$user."';
    //contraseña
    \$easy_db_data['default']['pass']        =   '".$pass."';
    //nombre de la base de datos
    \$easy_db_data['default']['db_name']     =   '".$dbname."';
    //codificación a usar
    \$easy_db_data['default']['dbchar']      =   'utf8';
    //tipo de servidor
    \$easy_db_data['default']['db_driver']   =   '".$driver."';

    /*****************************************************************************************
                              AUTOCARGA DE MODULOS
    *****************************************************************************************/

    \$easy_auto_load = array();
    //autocarga de helpers
    \$easy_auto_load['helpers'] = array('HEasy_Html','HEasy_Date','HEasy_File');


    /*****************************************************************************************
                             COSAS UTILIES
    *****************************************************************************************/



    /*****************************************************************************************
                             PARA DATOS DE LA SESSION
    *****************************************************************************************/

    //tiempo de la sessión en segundos
    define('SESSION_TIME',360);

    /*****************************************************************************************
    *****************************************************************************************/

    //cargando las variables definidas para tenerlas disponibles en el sistema
    Easy_Session::register(array('easy_db_data'=>\$easy_db_data,'easy_auto_load'=>\$easy_auto_load));

    /*****************************************************************************************
    *****************************************************************************************/
?>";
            $configFile->genFile($infoFile);



            //creo el fichero indexController.php
            $controlllerFile = new HEasy_File("indexController.php",$appPath.$name.DS."controllers".DS);
            $infoController = "<?php

    class indexController extends Easy_Controller
    {
        function index() {
            \$this->assign('_title','$name');
            \$this->assign('title','Bienvenidos a $name');
            \$this->setFlashMessage('Probando infomaciones rápidas.');
            \$this->renderizar('index');
        }
    }";
            $controlllerFile->genFile($infoController);

            //crear el main menu
            if($compiler == "Smarty")
                $ext = "tpl";
            else
                $ext = "twig";

            $menuFile = new HEasy_File("menu.".$ext,$appPath.$name.DS."views".DS."layout".DS."menu".DS);
            $menuFile->genFile("Poner el codigo html perteneciente al menú");

            //crear el style para el default layout
            $styledefualtLayoutFile = new HEasy_File("style.css",$appPath.$name.DS."views".DS."layout".DS."default".DS."css".DS);
            $infocssDefaultLayout = "*{padding: 0;margin: 0;}

body{
    background-color: #efefef;
}

#global{
    margin: auto;
    width: 100%;
    height: 100%;
    background: rgba(161,209,222,1);
    background: -moz-linear-gradient(top, rgba(161,209,222,1) 0%, rgba(239,239,239,1) 64%, rgba(239,239,239,1) 100%);
    background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(161,209,222,1)), color-stop(64%, rgba(239,239,239,1)), color-stop(100%, rgba(239,239,239,1)));
    background: -webkit-linear-gradient(top, rgba(161,209,222,1) 0%, rgba(239,239,239,1) 64%, rgba(239,239,239,1) 100%);
    background: -o-linear-gradient(top, rgba(161,209,222,1) 0%, rgba(239,239,239,1) 64%, rgba(239,239,239,1) 100%);
    background: -ms-linear-gradient(top, rgba(161,209,222,1) 0%, rgba(239,239,239,1) 64%, rgba(239,239,239,1) 100%);
    background: linear-gradient(to bottom, rgba(161,209,222,1) 0%, rgba(239,239,239,1) 64%, rgba(239,239,239,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a1d1de', endColorstr='#efefef', GradientType=0 );
    background-repeat: no-repeat;
    background-color: #efefef;
}
";
            $styledefualtLayoutFile->genFile($infocssDefaultLayout);

            //crear el js para el default layout
            $jsdefualtLayoutFile = new HEasy_File("functions.js",$appPath.$name.DS."views".DS."layout".DS."default".DS."js".DS);
            $infojsDefaultLayout = "";
            $jsdefualtLayoutFile->genFile($infojsDefaultLayout);

            //crear el default layout
            $defualtLayoutFile = new HEasy_File("default.".$ext,$appPath.$name.DS."views".DS."layout".DS."default".DS);
            $infoDefaultLayout = $this->defaultLayout($compiler);
            $defualtLayoutFile->genFile($infoDefaultLayout);

            //crear el vista index
            $indexViewFile = new HEasy_File("index.".$ext,$appPath.$name.DS."views".DS."index".DS);
            if($compiler == "Smarty")
                $infIndexView = "<div style='text-align: center; color: #0000ff'><h1> {\$title} </h1></div>
    <div style='text-align: center; color: #0000ff'> Compañía: {\$APP_COMPANY}</div>
    <div style='text-align: center; color: #0000ff'> Contacto: <a http='{\$APP_MAILTO}'>{$mailto}</a></div>
    <div style='text-align: center; color: #0000ff'> Compilador: {$compiler}</div>
    <div style='text-align: center; color: #0000ff'> Slogan: {\$APP_SLOGAN}</div>
    <br>
    <hr>
    <div style='text-align: center; color: #0000ff'><h2>Variables Disponibles en las Vistas</h2></div>
    <br>
    <div style='text-align: center; color: #0000ff'> <strong>ROOT</strong>: {\$ROOT}</div>
    <div style='text-align: center; color: #0000ff'> <strong>BASE_URL</strong>: {\$BASE_URL}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_PATH</strong>: {\$APP_PATH}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_NAME</strong>: {\$APP_NAME}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_FOLDER_NAME</strong>: {\$APP_FOLDER_NAME}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_SLOGAN</strong>: {\$APP_SLOGAN}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_COMPANY</strong>: {\$APP_COMPANY}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_MAILTO</strong>: {\$APP_MAILTO}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_layout</strong>: {\$_layout}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_layout_ruta_css</strong>: {\$_layout_ruta_css}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_layout_ruta_js</strong>: {\$_layout_ruta_js}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_layout_ruta_img</strong>: {\$_layout_ruta_img}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_ruta_layout</strong>: {\$_ruta_layout}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_content</strong>: {\$_content}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_main_nav</strong>: {\$_main_nav}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_ruta_nav</strong>: {\$_ruta_nav}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_ruta_view</strong>: {\$_ruta_view}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_view_ruta_img</strong>: {\$_view_ruta_img}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_view_ruta_css</strong>: {\$_view_ruta_css}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_view_ruta_js</strong>: {\$_view_ruta_js}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_path_layout</strong>: {\$_path_layout}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_flashMessage</strong>: {\$_flashMessage}</div>
                ";
            else
                $infIndexView = "{% extends 'default.twig' %}
 {% block content %}
    <div style='text-align: center; color: #0000ff'><h1> {{title}} </h1></div>
    <div style='text-align: center; color: #0000ff'> Compañía: {{APP_COMPANY}}</div>
    <div style='text-align: center; color: #0000ff'> Contacto: <a http='{{APP_MAILTO}}'>$mailto</a></div>
    <div style='text-align: center; color: #0000ff'> Compilador: $compiler</div>
    <div style='text-align: center; color: #0000ff'> Slogan: {{APP_SLOGAN}}</div>
    <br>
    <hr>
    <div style='text-align: center; color: #0000ff'><h2>Variables Disponibles en las Vistas</h2></div>
    <br>
    <div style='text-align: center; color: #0000ff'> <strong>ROOT</strong>: {{ROOT}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>BASE_URL</strong>: {{BASE_URL}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_PATH</strong>: {{APP_PATH}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_NAME</strong>: {{APP_NAME}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_FOLDER_NAME</strong>: {{APP_FOLDER_NAME}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_SLOGAN</strong>: {{APP_SLOGAN}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_COMPANY</strong>: {{APP_COMPANY}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>APP_MAILTO</strong>: {{APP_MAILTO}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_layout</strong>: {{_layout}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_layout_ruta_css</strong>: {{_layout_ruta_css}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_layout_ruta_js</strong>: {{_layout_ruta_js}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_layout_ruta_img</strong>: {{_layout_ruta_img}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_ruta_layout</strong>: {{_ruta_layout}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_content</strong>: {{_content}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_main_nav</strong>: {{_main_nav}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_ruta_nav</strong>: {{_ruta_nav}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_ruta_view</strong>: {{_ruta_view}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_view_ruta_img</strong>: {{_view_ruta_img}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_view_ruta_css</strong>: {{_view_ruta_css}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_view_ruta_js</strong>: {{_view_ruta_js}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_path_layout</strong>: {{_path_layout}}</div>
    <div style='text-align: center; color: #0000ff'> <strong>_flashMessage</strong>: {{_flashMessage}}</div>
 {% endblock %}
";
            $indexViewFile->genFile($infIndexView);

            echo 1;
        }
        else
        {
            echo 2; //la aplicación existe;
        }


    }

    function indexHtml($nameFile,$dir)
    {
        $inf = "<html>
    <head>
        <title>403 SIN ACCESO</title>
        <script> setTimeout(function(){window.location = '../';},2000)</script>
    </head>
    <body>
        <p>No tiene acceso a este directorio.</p>
    </body>
</html>";

        $indexHtmlFile = new HEasy_File($nameFile,$dir);
        $indexHtmlFile->genFile($inf);
        unset($indexHtmlFile);
    }


    function defaultLayout($compiler)
    {
        switch($compiler){
            case "Smarty":
                return "<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>{\$_title} </title>

        {\$HEasy_Html->tag_link(\"{\$_layout_ruta_css}style.css\")}".
    "
        {if isset(\$_css) and count(\$_css) > 0}
            {section name=cssloop loop=\$_css}
                {\$HEasy_Html->tag_link({\$_css[cssloop]})}
            {/section}
        {/if}
        "."
    </head>
    <body>
        <div id='global'>
            <br>
            {include file= \$_content}
        </div>

        <!-- JS -->
        {\$HEasy_Html->script_link(\"{\$_layout_ruta_js}functions.js\")}

        <!-- Para pasar variables al javascript-->
        <script>
            var BASE_URL = \"{\$smarty.const.BASE_URL}\";
            var _path_img = '{\$_view_ruta_img}';
        </script>

        {if isset(\$_js) and count(\$_js) > 0}
            {section name=jsloop loop=\$_js}
                {\$HEasy_Html->script_link({\$_js[jsloop]})}
            {/section}
        {/if}
    </body>
</html>";
                break;
            case "Twig":
               return "<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>{{ _title }}</title>

        {{ HEasy_Html.tag_link(_layout_ruta_css~'style.css') }}

        {% if _css != null and _css|length > 0 %}
            {% for i in _css %}
                {{ HEasy_Html.tag_link(i)}}
            {% endfor %}
        {% endif %}

    </head>
    <body>
        <div id='global'>
            <br>
            {% block content %} Aquí va el titulo del sitio{% endblock%}
        </div>


        <!-- JS -->
        {{ HEasy_Html.script_link(_layout_ruta_js~'functions.js') }}

        <!-- Para pasar variables al javascript-->
        <script>
            var BASE_URL = '{{BASE_URL}}';
            var _path_img = '{{_view_ruta_img}}';
        </script>

        {% if _js != null and _js|length > 0 %}
            {% for i in _js %}
                {{ HEasy_Html.script_link(i)}}
            {% endfor %}
        {% endif %}
    </body>
</html>";
                break;

        }

    }

} 