/*SideBar navigation toggle*/
$(document).ready(function() {
    $('.hasSub').click(function() {
        var elem = $(this).find('.sub');
        elem.toggle();
        console.log('entro!');
        if (elem.css('display') === 'none') {
            console.log('up!');
            $(this).find('.glyphicon-chevron-up').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
        }
        else {
            console.log('down!');
            $(this).find('.glyphicon-chevron-down').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
        }
    });

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active").toggleClass("active-ls");
        $("#sidebar-wrapper").toggleClass("inactive-ls");
        if ($(this).hasClass('fa-toggle-left')) {
            $(this).removeClass('fa-toggle-left').addClass('fa-toggle-right');
        } else {
            $(this).removeClass('fa-toggle-right').addClass('fa-toggle-left');
        }
    });

    $('#btnMenuToggle').click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active").toggleClass("active-ls");
        $("#sidebar-wrapper").toggleClass("inactive-ls");
    });

});