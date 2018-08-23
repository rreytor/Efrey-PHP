/**
 * Created by rreytor on 20/01/2015.
 */

$(document).ready(function () {

    $("#msgError").hide();
    $("#msgInfo").hide();

    $("#btnCrear").on("click",function(){

        var name        = $("#name").val();
        var slogan      = $("#slogan").val();
        var company     = $("#company").val();
        var mailto      = $("#mailto").val();
        var compiler    = $("#compiler").val();
        var server      = $("#server").val();
        var user        = $("#user").val();
        var pass        = $("#pass").val();
        var dbname      = $("#dbname").val();
        var driver      = $("#driver").val();

        var error = false;


        $("input[required='true']").each(function(){
            if($(this).val() == "")
            {
                $(this).parent().addClass("has-error");
                error = true;
            }
        });

        if(!validEmail(mailto))
        {
            $("#mailto").parent().addClass("has-error");
            error = true;
        }

        if(error)
        {
            $("#msgErrorInf").html("<div><i class='fa fa-minus-circle' style='font-size: 20px;vertical-align: middle;'></i> <span style='vertical-align: middle'>Error en la entrada de los datos, debe llenar todos los campos correctamente</span></div>");
            $("#msgError").fadeIn();
        }
        else
        {
            $.post(BASE_URL+"crear/createApp",{name:name,slogan:slogan,company:company,mailto:mailto,compiler:compiler,server:server,user:user,pass:pass,dbname:dbname,driver:driver},function(data){
                if(data == 1)
                {
                    $("#msgInfoInf").html("<div><i class='fa fa-hand-o-right' style='font-size: 20px;vertical-align: middle;'></i> <span style='vertical-align: middle'>Aplicación creada con éxito</span></div>");
                    $("#msgInfo").fadeIn();
                }
                else{
                    $("#msgErrorInf").html("<div><i class='fa fa-minus-circle' style='font-size: 20px;vertical-align: middle;'></i> <span style='vertical-align: middle'>Ocurrió un error creando la aplicación, verifique que no exista.</span></div>");
                    $("#msgError").fadeIn();
                }

            });

        }

    });

    $("input").on('change',function(){
        if($(this).val() != "")
            $(this).parent().removeClass("has-error");
        else
            $(this).parent().addClass("has-error");
    });

    $("#mailto").on('change',function(){
        if(validEmail($("#mailto").val()))
            $(this).parent().removeClass("has-error");
        else
            $(this).parent().addClass("has-error");
    });



});

function validEmail(value) {
    var filter6=/[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}/;
    if (filter6.test(value))
        return true;
    else
        return false;
}

