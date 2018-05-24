

$(document).ready(function(){
    var $megustabtn = $('#megusta-btn');
    var $nomegustabtn = $('#no-megusta-btn');
    var cont = 1;
    renderValoracion();

    $('#colaborar-btn').on('click', function() {
        var proyectoId = this.dataset.proyectoid;
        var _url = '/proyecto/' + proyectoId + '/colaborar';
        var $this = $(this);
        

        $.ajax({
            url: _url,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                if(data.peticion_envidada) {
                    $this.css('color', 'yellow');
                } else {
                    $this.css('color', 'red');
                }
            },
            error: function(data) {
                console.log(data.responseJSON.error);
                $this.css('color', 'red');
            }
        });

        return false;
    });
    
    /**
 * muestra la valoracion que le habia dado
 * el usuario de la sesion al haberle dado a megusta o no me gusta
 * si no hay sesion iniciada esto no va a hacer nada
 */
function renderValoracion() {
    var $megustabtn = $('#no-megusta-btn');
    var $nomegustabtn = $('#megusta-btn');
    var $valoracionbtns = $('.valoracion-btn');
    var megusta = $megustabtn.data('valoracion');
    var nomegusta = $nomegustabtn.data('valoracion');

    if(typeof megusta !== 'undefined' && typeof nomegusta !== 'undefined') {
        $valoracionbtns.removeClass('valoracion-active');

        if(megusta === 1 && nomegusta === 0) {
            $megustabtn.addClass('valoracion-active');
        } else if(megusta === 0 && nomegusta === 1) {
            $nomegustabtn.addClass('valoracion-active');
        }
    }
}

    /**
     * Quita la valoracion del proyecto
     * @param proyecto
     */
    function quitarValoracion(proyecto) {
        var $valoracionbtns = $('.valoracion-btn');

        $.ajax({
           url: '/proyecto/' + proyecto + '/quitar_valoracion',
           type: 'GET',
           dataType: 'JSON',
           success: function(data) {
               $('.valoracion-btn').removeClass('valoracion-active');
               $valoracionbtns.data('valoracion', 0);
               console.log('Valoracion quitada');
           },
           error: function(data) {
               var response = JSON.parse(data.responseText);
               console.log(response.error);
           }
        });
    }


    $("#borrar-proyecto").on("click",function(){
        var name = $(this).attr("name");

        var BorrarUrl = '/proyecto/' + name + '/eliminar';

        console.log(BorrarUrl);

        $.ajax({
            url: BorrarUrl,
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
            }

        });
    });

    $('#project_etiquetas').on('keydown', function(){
        var nombreTag = $(this).val();

        $.ajax({
            url: '/tags/' + nombreTag ,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                // TODO poner en un ul los tags
                console.log(data);
            },
            error: function(data) {
                console.log(data.responseJSON.error);
            }
        });
    });

    $('#no-megusta-btn').on('click', function(){
        var $this = $(this);
        var proyecto = $this.data('proyectoid');
        var nomegusta = $this.data('valoracion');

        if(nomegusta === 1) {
            quitarValoracion(proyecto);
            return false;
        }

        $.ajax({
           url: '/proyecto/' + proyecto + '/desvalorar',
           type: 'GET',
           dataType: 'JSON',
           success: function(data) {
                console.log(data);
                if(data.valorado) {
                    $megustabtn.data('valoracion', 0);
                    $nomegustabtn.data('valoracion', 1);
                    renderValoracion();
                } else {
                    quitarValoracion(proyecto);
                }
           }
           ,
           error: function(data) {
               console.log(data.responseJSON.error);
           }
       });
    });

    $('#megusta-btn').on('click', function(){
        var $this = $(this);
        var proyecto = $this.data('proyectoid');
        var megusta = $this.data('valoracion');

        if(megusta === 1) {
            quitarValoracion(proyecto);
            return false;
        }

        $.ajax({
           url: '/proyecto/' + proyecto + '/valorar',
           type: 'GET',
           dataType: 'JSON',
           success: function(data) {
                console.log(data);
                if(data.valorado) {
                    $megustabtn.data('valoracion', 1);
                    $nomegustabtn.data('valoracion', 0);
                    renderValoracion();
                } else {
                    quitarValoracion(proyecto);
                }
           },
           error: function(data) {
               console.log(data.responseJSON.error);
           }
        });
    });
    
    $("#cursor").on("click",function()
    {     
        if(cont < $(".newProyect > form:nth-child(1) > div").length)
        {
            $(".newProyect > form:nth-child(1) > div:nth-child("+cont+")").hide("slow");
            cont++;
            $(".newProyect > form:nth-child(1) > div:nth-child("+cont+")").show("slow");
        }
    })
});
