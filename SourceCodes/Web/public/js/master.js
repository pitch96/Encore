let base_url = $("meta[name='base_url']").attr("content");
let user_id = $("meta[name='user_id']").attr("content");
$(function () {
    var url = window.location;
    // for single sidebar menu
    $('ul.nav-sidebar a').filter(function () {
        return this.href == url;
    })
    .css({'background-color': 'transparent'})
    .css({'color': '#fff'})
    .addClass('active');

    // for sidebar menu and treeview
    $('ul.nav-treeview a').filter(function () {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview")
        .css({'display': 'block'})
        .addClass('menu-open')
        .prev('a')
        .css({'background-color': 'green'})
        .addClass('active');

    //Initialize Select2 Elements
    $('.select2').select2().on('select2:open', function(e){
        $('.select2-search__field').attr('placeholder', 'Search here...');
    })

    //Initialize Select2 Elements
    $('.select2bs4').select2().on('select2:open', function(e){
        $('.select2-search__field').attr('placeholder', 'Search here');
    }).on('select2:open', function(e){
        $('.select2-search__field').attr('placeholder', 'Search here...');
    })

    // Data Tables Script
    $("#data-table, #order-table").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    $("#promoter-table").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $("#event-order-details-table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        $("#promotion-list-table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



        $("#order-details-table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            });
    
});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
    }
});
$(document).bind("ajaxSend", function () {
    $("#overlay").fadeIn(300);
}).bind("ajaxComplete", function () {
    $("#overlay").fadeOut(300);
});

$(document).ready(function(){
    $('#phone_no').mask('(000) 000-0000');
    $('#zipcode').mask('000000');
    $('.quantity').mask('000000000');
    $('.card-cvc').mask('000');
    $('.card-expiry-year').mask('0000');
    $('.card-expiry-month').mask('00');
    $('.card-num').mask('0000000000000000');
});

$('.numbersOnly').keyup(function () { 
    this.value = this.value.replace(/[^0-9\.]/g,'');
});

function testInput(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/[a-zåäö ]/i);
    return pattern.test(value);
}

$('.name-field').bind('keypress', testInput);

$(document).ready(function(){
    $('.show_password').on('click', function(){
        var show = $(this).data('value');
        if(show == 1){
            $(this).data('value', 0);
            $(this).html('<i class="fa fa-eye" style="left: 90% !important;" aria-hidden="true"></i>');
        }else{
            $(this).data('value', 1);
            $(this).html('<i class="fa fa-eye-slash" style="left: 90% !important;" aria-hidden="true"></i>');
        }
        show = $(this).data('value');
        $(this).siblings('.hide-show-password').attr('type',show==1?"text":"password"); 
    });
});

$(document).ready(function(){
    $(".toggle-menu").on('click', function(){
        let val = $(this).data('value');
        console.log(val);
        $(".toggle-menu").removeClass("menu-is-opening menu-open");
        $(".toggle-menu").find('.nav-treeview').css("display",'none');
        if(val === 0){
            $(this).addClass("menu-is-opening menu-open");
            $(this).children('.nav-treeview').css("display",'block');
            $(".toggle-menu").data('value', 0)
            $(this).data('value', 1)
        }else{
            $(".toggle-menu").data('value', 0)
        }
    })
});