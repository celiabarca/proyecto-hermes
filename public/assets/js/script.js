$( document ).ready(function() {
/**
 * Oculta el resto de elemetos y solo deja visible
 * la cantidad de elementos puesta en el atributo data-limit=""
 * de la clase .collapsible
 */
function ocultarApartirDeLimite() {
    $('.collapsible').each(function(){
        var $this = $(this);
        var limit = parseInt($this.data('limit'));
        var visibleElements = 0;
        $this.find('.collapsible-element').each(function(){
            var $this = $(this);
            if(visibleElements >= limit) {
                $this.hide();
            }
            visibleElements++;
        });
    });
}

/**
 * Muestra los elementos ocultos en un collapsible
 */
function verMas() {
    var $this = $(this);
    var collapsibles = $this.parent().find('.collapsible-element');
    $(collapsibles).show();
    $this.hide(); // oculta el boton de ver mas
}
    //alert($(window).width());
    //change images de imput email
    img = "/images/black-envelope.png";
    $(".email").focus(function(){
        $(".email").addClass("email2");
    });
    $(".email").blur(function(){
        $(".email").removeClass("email2");
    });
     
    
    //ocultar o mostrar formulario de respuesta de un formulario
    $(".responder").click(function(){
       $(this).parent().find(".respuesta").css("display", "block"); 
    });
//    $(".options>div:nth-child(1)").click(function(){
//        $(this).parent().parent().parent().parent().find(".test").css("display", "block"); 
//        console.log($(this).parent().parent().parent().parent().find(".test"));
//    });
    $(".closecomment").click(function(){
        $(this).parent().parent().css("display", "none"); 
        console.log($(this).parent().parent());
    });
    function sliderReguistro(){
         
    }

    var errorLogin = document.getElementById('errorLogin');

    if(typeof errorLogin !== 'undefined' && errorLogin != null) {
        $('#login-form-container').addClass('animated shake');
    }

    ocultarApartirDeLimite();
    $('.vermas-btn').on('click', verMas);
})