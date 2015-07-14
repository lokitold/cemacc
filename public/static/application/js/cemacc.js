/*SideBar navigation toggle*/
$(document).ready(function(){
    $('.hasSub').click(function(){
        var elem = $(this).find('.sub');
        elem.toggle();
        if (elem.css('display') === 'none')
            $(this).find('.down').removeClass('fa-caret-square-o-up').addClass('fa-caret-square-o-down');
        else
            $(this).find('.down').removeClass('fa-caret-square-o-down').addClass('fa-caret-square-o-up');
    });
    
    
});