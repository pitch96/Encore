jQuery( document ).ready(function() {

     // sticky Menu
     jQuery(window).scroll(function () {
        var sticky = $('header'),
                scroll = $(window).scrollTop();

        if (scroll >= 70)
            sticky.addClass('fixed');
        else
            sticky.removeClass('fixed');
    });

    // toogle menu
    jQuery('.toggle-menu').click(function (e) {
        e.stopPropagation();
        jQuery('body').toggleClass('open-nav');
        jQuery(this).toggleClass('open');
    });

    // date rangepicker
    var date = new Date();
    jQuery('#dates1').daterangepicker({
        endDate: moment(date).add(7,'days')
    });
    jQuery('#dates2').daterangepicker();

});

jQuery(document).ready(function () {
    jQuery(".dropdown-link").on("click", function () {
        jQuery(".dropdown-options").toggle();
    });

jQuery(".dropdown-options li a").on("click", function () {
    var section = jQuery(this).data("section");
    jQuery(".dropdown-link").text(jQuery(this).text());
    jQuery(".dropdown-options").hide();

// Scroll to the selected section with a 100px offset
var targetSection = jQuery("#" + section);
if (targetSection.length) {
    jQuery('html, body').animate({
    scrollTop: targetSection.offset().top - 178
    }, 700); // You can adjust the scroll speed (800 milliseconds in this case)
}
});
});