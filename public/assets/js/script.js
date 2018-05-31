$( document ).ready(function() {
/**
 * Oculta el resto de elemetos y solo deja visible
 * la cantidad de elementos puesta en el atributo data-limit=""
 * de la clase .collapsible
 */
function ocultarApartirDeLimite(collapsible) {
    var limit = parseInt(collapsible.dataset.limit);
    var childElements = collapsible.children;
    var visibleElements = 0;

    for(var i = 0; i < childElements.length; i++) {
        if(childElements[i].classList.contains('collapsible-element')) {
            if(visibleElements >= limit) {
                childElements[i].style.display = 'none';
            } else {
                visibleElements++;
            }
        }
    }
}

/**
 * Muestra los elementos ocultos en un collapsible
 */
function verMas() {
    var $this = $(this);
    var collapsibles = $this.parent().children('.collapsible-element');
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

    var collapsibles = document.getElementsByClassName('collapsible');

    for(var i = 0; i < collapsibles.length; i++) {
        ocultarApartirDeLimite(collapsibles[i]);
    }

    $('.vermas-btn').on('click', verMas);

    $('.campo-opcional').hide();
    $('#mostrar-campos-opcionales').on('change', function() {
        var active = $('#mostrar-campos-opcionales:checked').val();

        if(active) {
            console.log("active");
            $('.campo-opcional').show();
        } else {
            $('.campo-opcional').hide();
            $('.campo-opcional input').val(""); // quita los values al desactivar el checkbox
        }
    });
})