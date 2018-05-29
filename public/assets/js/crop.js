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
    this.mapValues = mapValues;
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

function map(x, in_min, in_max, out_min, out_max) {
    return (x - in_min) * (out_max - out_min) / (in_max - in_min) + out_min;
}

function mapValues() {
    var $cropimg = $('#crop-image');
    imagecoords.x = map(imagecoords.x, 0, $cropimg.width(), 0, this.img.width);
    imagecoords.y = map(imagecoords.y, 0, $cropimg.height(), 0, this.img.height);
    imagecoords.w = map(imagecoords.w, 0, $cropimg.width(), 0, this.img.width);
    imagecoords.h = map(imagecoords.h, 0, $cropimg.height(), 0, this.img.height);
}

function aplicarCrop() {
    document.body.appendChild(this.canvas);
    this.mapValues();
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

// funcion sacada de stackoverflow
function dataURItoBlob(dataURI) {
    // convert base64/URLEncoded data component to raw binary data held in a string
    var byteString;
    if (dataURI.split(',')[0].indexOf('base64') >= 0)
        byteString = atob(dataURI.split(',')[1]);
    else
        byteString = unescape(dataURI.split(',')[1]);

    // separate out the mime component
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

    // write the bytes of the string to a typed array
    var ia = new Uint8Array(byteString.length);
    for (var i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ia], {type:mimeString});
}

$(document).ready(function(){
    var data_url;
    var filename;

    $('#cropbox').hide();

    $('#editar_usuario_img').on('change', function(event){
        var c = new crop();
        var img = event.target.files[0];

        filename = img.name;
        c.initCrop(img);

        $('#cropbox').show();

        $('#aceptar-crop-btn').on('click', function(){
            data_url = c.aplicarCrop();
        });

        $('#cancelar-crop-btn').on('click', function(){
            c.cancelarCrop();
        });
    });
    /*
    $("form[name='editar_usuario']").on('submit', function(event){
        event.preventDefault();

        var form = new FormData(document.getElementsByName("editar_usuario")[0]);
        var blob = dataURItoBlob(data_url);

        form.set("img", blob, filename);
        form.submit();
    });
    */
});