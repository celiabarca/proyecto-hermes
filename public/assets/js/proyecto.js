$(document).ready(function(){
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
<<<<<<< HEAD
    
    $("#borrar-proyecto").on("click",function()
    {   
        var name = $(this).attr("name");
        
        var BorrarUrl = '/proyecto/' + name + '/eliminar';
        
        console.log(BorrarUrl);
            
            $.ajax({
                url: BorrarUrl,
                datatype: 'JSON',
                success: function(response)
                {
                    console.log(response);                
                }

           }) 
           
=======

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
                console.log(data.responseJSON);
            }
        });
    });

    $('#no-megusta-btn').on('click', function(){
        var proyecto = $(this).data('proyectoid');

       $.ajax({
           url: '/proyecto/' + proyecto + '/desvalorar',
           type: 'GET',
           dataType: 'JSON',
           success: function() {

           }
           ,
           error: function() {

           }
       });
>>>>>>> e52575a634a68d652f841f4c42caa027c2377b15
    });
});
