$(document).ready(function () {
    /**
     * Oculta el resto de elemetos y solo deja visible
     * la cantidad de elementos puesta en el atributo data-limit=""
     * de la clase .collapsible
     */
    function ocultarApartirDeLimite() {
        $('.collapsible').each(function () {
            var $this = $(this);
            var limit = parseInt($this.data('limit'));
            var visibleElements = 0;
            $this.find('.collapsible-element').each(function () {
                var $this = $(this);
                if (visibleElements >= limit) {
                    $this.hide();
                }
                visibleElements++;
            });

            var $childrenCollapsibles = $this.children('.collapsible');

            if ($childrenCollapsibles) {
                $childrenCollapsibles.hide();
            }
        });
    }

    /**
     * Muestra los elementos ocultos en un collapsible
     */
    function verMas() {
        var $this = $(this);
        var collapsibles = $this.parent().children('.collapsible-element');
        $(collapsibles).show();

        var $childrenCollapsibles = $this.parent().children('.collapsible');

        if ($childrenCollapsibles) {
            $childrenCollapsibles.show();
        }

        $this.hide(); // oculta el boton de ver mas
    }
    //alert($(window).width());
    //change images de imput email
    img = "/images/black-envelope.png";
    $(".email").focus(function () {
        $(".email").addClass("email2");
    });
    $(".email").blur(function () {
        $(".email").removeClass("email2");
    });


    //ocultar o mostrar formulario de respuesta de un formulario
    $(".responder").click(function () {
        $(this).parent().find(".respuesta").css("display", "block");
    });
//    $(".options>div:nth-child(1)").click(function(){
//        $(this).parent().parent().parent().parent().find(".test").css("display", "block"); 
//        console.log($(this).parent().parent().parent().parent().find(".test"));
//    });
    $(".closecomment").click(function () {
        $(this).parent().parent().css("display", "none");
        console.log($(this).parent().parent());
    });
    function sliderReguistro() {

    }

    var errorLogin = document.getElementById('errorLogin');

    if (typeof errorLogin !== 'undefined' && errorLogin != null) {
        $('#login-form-container').addClass('animated shake');
    }

    ocultarApartirDeLimite();
    $('.vermas-btn').on('click', verMas);







    /************************celia RANGE********************/
    var el, newPoint, newPlace, offset;
    money=0;
    
    // Select all range inputs, watch for change
    $("input[type='range']").change(function () {
        el = $(this);
        width = el.width();
        newPoint = (el.val() - el.attr("min")) / (el.attr("max") - el.attr("min"));
        offset = -1.3;
        if (newPoint < 0) {
            newPlace = 0;
        } else if (newPoint > 1) {
            newPlace = width;
        } else {
            newPlace = width * newPoint + offset;
            offset -= newPoint;
        }
        /***RESPONSIVE****/
        responsive = $(window).width();
        //alert(responsive);
        money= el.val();
        if(responsive < 480 && responsive > 400 && money >9500 ){
            newPlace = newPlace - 15; alert("hola");
        }else if(responsive < 400 && responsive > 100 && money >9400 ){
            newPlace = newPlace - 30;
//            alert("hola55");
            
        }else{
           newPlace = newPlace; 
        }
        el.next("output").css({left: newPlace, marginLeft: offset + "%"}).text(el.val());
        
    })



            // Fake a change to position bubble at page load
            .trigger('change');

});