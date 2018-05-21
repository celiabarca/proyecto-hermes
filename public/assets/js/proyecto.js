$(document).ready(function(){
    $('#colaborar-btn').on('click', function() {
        var proyectoId = this.dataset.proyectoid;
        var _url = '/proyecto/' + proyectoId + '/colaborar';
        var $this = $(this);

        $.ajax({
            url: _url,
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
           
    });
});
