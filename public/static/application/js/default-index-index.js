$(document).ready(function() {



    $('#slideEmpresa').flexslider({
        animation: "slide",
        animationLoop: true,
        itemWidth: 150,
        slideshowSpeed: 2800,
        animationSpeed: 20000,
        pauseOnHover: true,
        controlNav: false,
        minItems: 6,
        maxItems: 100,
        itemMargin: 30,
        directionNav: false
    });

    $('#slidePrincipal').flexslider({
        animation: "fade",
        animationLoop: true,
        minItems: 1,
        maxItems: 1,
        startAt: 0,
        slideshowSpeed: 5000,
        animationSpeed: 1000
    });


    $('.slidePublicidad').flexslider({
        animation: "fade",
        animationLoop: true,
        minItems: 1,
        maxItems: 1,
        startAt: 0,
        slideshowSpeed: 5000,
        animationSpeed: 1000,
        controlNav: false,
        directionNav: false
    });

    $('#slider').nivoSlider();

//  var nivoHtml = $(".nivo-controlNav").html();
//  var newHtml = "<div class='nivo-controlNav-wrapper'><div class='nivo-controlNav'>" + nivoHtml + "</div></div>";
//  $(".nivo-controlNav").remove();
//  $(".nivoSlider").append(newHtml);

    $('#asesoria').carouFredSel({
        items: 4,
        direction: "up",
        scroll: {
            items: 2,
            easing: "elastic",
            duration: 1000,
            pauseOnHover: true
        }
    });

});

//////////// ///////////////



