$( document ).ready(function() {
    //change images de imput email
    img = "/images/black-envelope.png";
    $(".email").click(function(){
        $(".email").removeClass("email").addClass("email2");
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
        $(this).parent().parent().parent().parent().find(".test").css("display", "none"); 
        console.log($(this).parent().parent().parent().parent().parent().find(".test"));
    });
});