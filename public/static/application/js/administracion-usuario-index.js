$(document).ready(function() {
    $('body').on('click','.ver',function(e) {
        e.preventDefault();
        $.ajax({
            url: "/administracion/usuario/ver",
            data: {
                id: $(this).attr('usuario')
            },
            success: function(data) {
                $("#verUsuarioModal .modal-body").html(data);
                $('#verUsuarioModal').modal('show');
            }
        });
    });
});