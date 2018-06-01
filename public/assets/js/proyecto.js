
$(document).ready(function () {
    var $megustabtn = $('#megusta-btn');
    var $nomegustabtn = $('#no-megusta-btn');
    var cont = 1;
    var tags = [];
    renderValoracion();
    
    function getTags()
    {
        return tags;
    }
    
    function setTags(tag)
    {
        for(var z = tags.length;z!=0;z--)
        {
            tags.pop();
        }
        for(var z = 0; z!=tag.length;z++)
        {
            tags.push(tag[z].nombre); 
        }        
    }

    $('#colaborar-btn').on('click', function () {
        var proyectoId = this.dataset.proyectoid;
        var _url = '/proyecto/' + proyectoId + '/colaborar';
        var $this = $(this);


        $.ajax({
            url: _url,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                if (data.peticion_envidada) {
                    $this.css('color', 'yellow');
                } else {
                    $this.css('color', 'red');
                }
            },
            error: function (data) {
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

        if (typeof megusta !== 'undefined' && typeof nomegusta !== 'undefined') {
            $valoracionbtns.removeClass('valoracion-active');

            if (megusta === 1 && nomegusta === 0) {
                $megustabtn.addClass('valoracion-active');
            } else if (megusta === 0 && nomegusta === 1) {
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
            success: function (data) {
                $('.valoracion-btn').removeClass('valoracion-active');
                $valoracionbtns.data('valoracion', 0);
                console.log('Valoracion quitada');
            },
            error: function (data) {
                var response = JSON.parse(data.responseText);
                console.log(response.error);
            }
        });
    }


    $("#borrar-proyecto").on("click", function () {
        var name = $(this).attr("name");

        var BorrarUrl = '/proyecto/' + name + '/eliminar';
        $.ajax({
            url: BorrarUrl,
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
            }

        });
    });
    
    
    $('#project_etiquetas').autocomplete({
      source: getTags()
    });
    
    //taags
    
        function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( "#project_etiquetas" )
      // don't navigate away from the field on tab when selecting an item
      .on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            tags, extractLast( request.term ) ) );
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
      });
  
    
    //end tags
    

    $('#project_etiquetas').on('keydown', function () {
        var nombreTag = $(this).val();
        inputTags = nombreTag.split(",");
        var search = inputTags[inputTags.length-1].trim();
        console.log(search);
        $.ajax({
            url: '/tags/' + search,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) 
            {
                // TODO poner en un ul los tags     
                        setTags(data.tags);
    
            },
            error: function (data) {
                console.log(data.responseJSON.error);
            }
        });
    });
    
    
    $("ul").on('click', "li",function()
    {
        console.log("hola");
    })
    
    $('#no-megusta-btn').on('click', function () {
        var $this = $(this);
        var proyecto = $this.data('proyectoid');
        var nomegusta = $this.data('valoracion');

        if (nomegusta === 1) {
            quitarValoracion(proyecto);
            return false;
        }

        $.ajax({
            url: '/proyecto/' + proyecto + '/desvalorar',
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if (data.valorado) {
                    $megustabtn.data('valoracion', 0);
                    $nomegustabtn.data('valoracion', 1);
                    renderValoracion();
                } else {
                    quitarValoracion(proyecto);
                }
            }
            ,
            error: function (data) {
                console.log(data.responseJSON.error);
            }
        });
    });

    $('#megusta-btn').on('click', function () {
        var $this = $(this);
        var proyecto = $this.data('proyectoid');
        var megusta = $this.data('valoracion');

        if (megusta === 1) {
            quitarValoracion(proyecto);
            return false;
        }

        $.ajax({
            url: '/proyecto/' + proyecto + '/valorar',
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                console.log(data);
                if (data.valorado) {
                    $megustabtn.data('valoracion', 1);
                    $nomegustabtn.data('valoracion', 0);
                    renderValoracion();
                } else {
                    quitarValoracion(proyecto);
                }
            },
            error: function (data) {
                console.log(data.responseJSON.error);
            }
        });
    });
    
    //$("#next").css("display", "none");
    $("#next").on("click", function ()
    {
        if (cont < $(".newProyect > form:nth-child(1) > div").length)
        {

            $(".newProyect > form:nth-child(1) > div:nth-child(" + cont + ")").css("display", "none");
            cont++;
            $(".newProyect > form:nth-child(1) > div:nth-child(" + cont + ")").css("display", "flex");

        }
    })
    $("#previous").on("click", function ()
    {
        if (cont > 1)
        {
            $(".newProyect > form:nth-child(1) > div:nth-child(" + cont + ")").css("display", "none");
            cont--;
            $(".newProyect > form:nth-child(1) > div:nth-child(" + cont + ")").css("display", "flex");

        }


    });  
    $('#previous').css("display", "none");
    $('#nuevoProjecto>div:nth-child(1)>div>input').click(function(){
        
        if (cont != 1 && cont != $(".newProyect > form:nth-child(1) > div").length) {
            $("#next").css("display", "block");
            $('#previous').css("display", "block");

        } else if (cont == 1) {
            $("#next").css("display", "block");
            $('#previous').css("display", "none");
        } else if (cont == $(".newProyect > form:nth-child(1) > div").length) {
            $("#next").css("display", "none");
            $('#previous').css("display", "block");
        }
    });
    
    $("textarea").on("blur",function()
    {
        var inapropiadas = ['inutil','capullo','gilipollas','mierda'];
        
        var comentario = $(this).val().split(" ");
        
        for(var a = 0;a!=comentario.lenght;a++)
            if(inapropiadas.contains(comentario[a]))
            {
                comentario[a] = "@(%$=)(/&&$";
            }
            var join = comentario.joins(" ");
            $(this).val(join);
    });


    
    
    /* Validacion formulario creacion Proyecto */
    
    $("#project_meta").on("blur",function()
    {
       //aler($(this))
    })


});
