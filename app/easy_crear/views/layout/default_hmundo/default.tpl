<!DOCTYPE html>
<html>
    <head lang="es">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" />

        <title>{$_title}</title>

        <!--{$HEasy_Html->tag_link("{$_layout_ruta_img}favicon.ico","shortcut icon","image/x-icon")}-->
        <link href="{$BASE_URL}favicon.ico" type="image/x-icon" rel="shortcut icon" />
        
        {$HEasy_Html->tag_link("{$_layout_ruta_css}reset.css")}
        {$HEasy_Html->tag_link("{$_layout_ruta_css}iconFont.min.css")}
        {$HEasy_Html->tag_link("{$_layout_ruta_css}bootstrap.css")}
        {$HEasy_Html->tag_link("{$_layout_ruta_css}style.css")}

        {if isset($_css) and count($_css) > 0}      
            {section name=cssloop loop=$_css}      
                {$HEasy_Html->tag_link({$_css[cssloop]})}                
            {/section}      
        {/if}	

        <script>
            var BASE_URL = "{$smarty.const.BASE_URL}";         
            var _path_img = "{$_view_ruta_img}";
        </script>
        


    </head>
    <body>
        <div id="global">
            {include file= $_content}
        </div>

        <!-- Se incluyen los js al final de la página para cargar más rapido la información..-->
        {$HEasy_Html->script_link("{$_layout_ruta_js}jquery-1.11.1.min.js")}
        {$HEasy_Html->script_link("{$_layout_ruta_js}bootstrap.js")}
        {$HEasy_Html->script_link("{$_layout_ruta_js}php.js")}
        {$HEasy_Html->script_link("{$_layout_ruta_js}default.js")}

        {if isset($_js) and count($_js) > 0}
            {section name=jsloop loop=$_js}
                {$HEasy_Html->script_link({$_js[jsloop]})}
            {/section}
        {/if}
    </body>
</html>