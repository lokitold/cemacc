$(document).ready(function() {
    $('.ver').click(function(e){
        e.preventDefault();
        $.ajax({
            url: "/abogado/implicados/ver",
            data: {
                implicado: $(this).attr('implicado'),
                caso: $(this).attr('caso')
            },
            success: function(data) {
                $("#modalVerImplicado .modal-body").html(data);
                $("#modalVerImplicado").modal('show')
            }
        });
    });
});
