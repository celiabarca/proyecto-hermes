var imagecoords = {
    x: 0,
    y: 0,
    w: 0,
    h: 0
};

function updateCoords(c) {
    imagecoords.x = c.x;
    imagecoords.y = c.y;
    imagecoords.w = c.w;
    imagecoords.h = c.h;
}

function crop() {
    this.img = new Image();
    this.canvas = document.createElement('canvas');
    this.initCrop = initCrop;
    this.aplicarCrop = aplicarCrop;
    this.cancelarCrop = cancelarCrop;
}

function initCrop(img) {
    var $cropimg = $('#crop-image');
    var reader = new FileReader();
    var self = this;

    reader.onload = function(e) {
        $cropimg.attr('src', e.target.result);
        $cropimg.Jcrop({
            onSelect: updateCoords,
            onChange: updateCoords,
            aspectRatio: 1
        });

        self.img.src = reader.result;
    };

    reader.readAsDataURL(img);
}

function aplicarCrop() {
    document.body.appendChild(this.canvas);
    this.canvas.width = imagecoords.w;
    this.canvas.height = imagecoords.h;
    var ctx = this.canvas.getContext('2d');
    ctx.drawImage(this.img, imagecoords.x, imagecoords.y, imagecoords.w, imagecoords.h, 0, 0, this.canvas.width, this.canvas.height);
    return this.canvas.toDataURL('image/png');
}

function cancelarCrop() {
    var $inputimg = $('#editar_usuario_img');
    $inputimg.replaceWith($inputimg.clone(true));
    document.body.removeChild(this.canvas);
    $('#cropbox').hide();
}

$(document).ready(function(){
    $('#cropbox').hide();

    $('#editar_usuario_img').on('change', function(event){
        var img = event.target.files[0];
        var c = new crop();
        c.initCrop(img);
        $('#cropbox').show();
        $('#aceptar-crop-btn').on('click', function(){
            c.aplicarCrop();
        });
        $('#cancelar-crop-btn').on('click', function(){
            c.cancelarCrop();
        });
    });
});