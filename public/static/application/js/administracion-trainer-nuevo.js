$(document).ready(function() {

    $('.summernote').summernote({
        height: 300
    });

    $(".btnGuardar").click(function(e) {
        e.preventDefault();
        var descripcion = $("#descripcion").parent().find(".note-editable").html();

        $("#txtDescripcion").val(descripcion);

        $("#frmTrainer").submit();
    })

    function readURL(input) {
        var posicion = $("input[name=posicion]:checked").val();
        if (!/(\.bmp|\.gif|\.jpg|\.jpeg|\.png)$/i.test(input.value))
        {
            alert('INVALID FILE');
            $("#file").val('');
            return false;
        }

        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function(e) {
                var image = new Image();
                image.src = e.target.result;

                image.onload = function() {
                    // now we have the image.
                    var imgW = image.width;
                    var imgH = image.height;
                    if (imgW != 155 || imgH != 200) {
                        alert("Las dimensiones de la imagen debe ser 155x200");
                        $("#file").val('');
                        return false;
                    }
                    $('#preview').attr('src', e.target.result);
                    $('#preview').parent().removeClass('hide');
                };
                //$('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('body').on("change", "#file", function() {
        readURL(this);
    });

});

//////////// ///////////////



