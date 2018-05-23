$( document ).ready(function() {
    //alert($(window).width());
    //change images de imput email
    img = "/images/black-envelope.png";
    $(".email").focus(function(){
        $(".email").removeClass("email").addClass("email2");
    });
     $(".email2").focusout(function(){
         //alert("sdkjljdsl");
        //$(".email2").removeClass("email2").addClass("email");
    });
    
    //ocultar o mostrar formulario de respuesta de un formulario
    $(".responder").click(function(){
        //alert("hola");
       $(this).parent().find(".respuesta").css("display", "block"); 
    });
    $(".options>div:nth-child(1)").click(function(){
        //alert("vdjclxkvcxdlkcdsakkmcdlmñczdñkzcd");
        $(this).parent().parent().parent().parent().find(".test").css("display", "block"); 
        console.log($(this).parent().parent().parent().parent().find(".test"));
    });
    $(".closecomment").click(function(){
        //alert("vdjclxkvcxdlkcdsakkmcdlmñczdñkzcd");
        $(this).parent().parent().css("display", "none"); 
        console.log($(this).parent().parent());
    });
    function sliderReguistro(){
         
    }
});