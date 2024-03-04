//  header 
$(function() {

    $(window).scroll(function() {
        if ($(this).scrollTop() >= 90) {
            $('nav').addClass('change');
        } else {
            $('nav').removeClass('change');
        }
    });

    $('.mobile-nav').click(function() {
        $('.nav-right').toggleClass('toggle');
    })

    $('.showVid').click(function() {
        $('.videoModal').addClass('toggle');
        $('.videoModal iframe').addClass('OpenVideo');
    });
    $('.videoModal').click(function() {
        $('.videoModal').removeClass('toggle');
        $('.videoModal iframe').removeClass('OpenVideo');
    });

    var headerHeight = $('nav').outerHeight();
    $('.smooth-scroll').click(function(e) {
        var linkHref = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(linkHref).offset().top - headerHeight + 1
        }, 700);
        e.preventDefault();
    })

});


$('.owl_carousel_3').owlCarousel({
    loop: true,
    nav: true,
    navText: [
        "<i class='fa fa-angle-left'></i>",
        "<i class='fa fa-angle-right'></i>"
    ],
    autoplay: true,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 3
        },
        1200: {
            items: 4
        }
    }
})

//auto carousel footer section