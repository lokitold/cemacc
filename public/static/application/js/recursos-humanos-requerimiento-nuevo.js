$(document).ready(function() {

    $('#fechaLimite').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd/mm/yy'
    });

    $('body').on('submit', '#frmAgregarPersonal', function(e) {
        e.preventDefault();
        var cont = $('#tblPersonal >tbody >tr').length + 1;
        //alert(cont);
        var row = '<tr><td>' + cont + '</td>';
        row += '<td class="puesto">' + $("#puesto").val() + '</td>';
        row += '<td class="funcion">' + $("#funcion").val() + '</td>';
        row += '<td class="sueldo">' + $("#sueldo").val() + '</td></tr>';

        $("#tblPersonal").append(row);
        $("#puesto").val('');
        $("#funcion").val('');
        $("#sueldo").val('');
        $("#modalAgregarPersonal").modal('hide');
    });

    $('body').on('click', '#btnAgregarCategoria', function() {
        var num = $("#dvCategoria .lblCategoria").length;
        var val = $("#categoria option:selected").val();
        var txt = $("#categoria option:selected").text();
        var count = 0;
        $('.lblCategoria').each(function(){
            if($(this).attr('id') == val){
                count++;
            }
        });
        if (val != '' && count == 0) {
            var lbl = '<div><span id="' + val + '"class="label label-success lblCategoria">' + txt + '<span title="Quitar" style="cursor:pointer;" class="suprimir"> x</span><br/></span></div>';
//            if (num % 2 == 0 && num != 0) {
//                lbl += '<br/>';
//            }
            $("#dvCategoria").append(lbl);
        }
    });
    
    $('body').on('click','.suprimir',function(){
       $(this).parent().parent().remove(); 
    });
    
    $('body').on('click','#btnEnviar',function(){
        var filas = $('#tblPersonal tbody').find('tr');
        var cat = '';
        var c = 0;
        if(filas.length == 0){
            alert('Debe agregar los puestos requeridos! ');
            return false;
        }
         var dataPersonal = new Array();

         $(filas).each(function(index) {
            var nombre = $(this).find('.puesto').html();
            var funcion = $(this).find('.funcion').html();
            var sueldo = $(this).find('.sueldo').html();
            dataPersonal[index] = nombre+'|'+funcion+'|'+sueldo;
        });
        
        $(".lblCategoria").each(function() {
            c++;
           if(c <= 1){
             cat +=  $(this).attr('id');
           }else{
               cat += ','+$(this).attr('id');
           }
        });
        
        if(c == 0){
            alert('Debe Seleccionar A que empresar enviar ');
            return false;
        }
        $("#empresaEnvio").val(cat);
        $("#dataPersonal").val(dataPersonal);
    })


});

//////////// ///////////////



