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

   // toogle menu
   jQuery('.toggle-menu').click(function (e) {
    e.stopPropagation();
    jQuery('body').toggleClass('open-nav');
    jQuery(this).toggleClass('open');
});

// date rangepicker
jQuery('input[name="dates"]').daterangepicker();


// Quantity plus and minus
var buttonPlus  = $(".qty-btn-plus");
var buttonMinus = $(".qty-btn-minus");

var incrementPlus = buttonPlus.click(function() {
var $n = $(this)
.parent(".qty-container")
.find(".input-qty");
$n.val(Number($n.val())+1 );
});

var incrementMinus = buttonMinus.click(function() {
var $n = $(this)
.parent(".qty-container")
.find(".input-qty");
var amount = Number($n.val());
if (amount > 0) {
    $n.val(amount-1);
}
});

jQuery(".at-title").click(function () {
    jQuery(this).toggleClass("active").next(".at-tab").slideToggle().parent().siblings().find(".at-tab").slideUp().prev().removeClass("active");
});

});