var base_url = $("meta[name='base_url']").attr("content");
var user_id = $("meta[name='user_id']").attr("content");
// Toastr Message
$(document).ready(function () {
    // Data Tables Script
    $("#data-table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
});

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

$(document).ready(function () {
    $('#phone_no, .phone_no').mask('(000) 000-0000');
    $('#zipcode, .zipcode').mask('000000');
    $('.cvv').mask('000');
    $('.year').mask('0000');
    $('.card_month').mask('00');
    $('.card_no').mask('0000000000000000');
});

function testInput(event) {
    var value = String.fromCharCode(event.which);
    var pattern = new RegExp(/[a-zåäö ]/i);
    return pattern.test(value);
}

$('.name-field').bind('keypress', testInput);

$('#email').on('keyup', function () {
    var valid = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(this.value) && this.value.length;
    $('.email-validation').html((valid ? '' : ' Invalid email id')).show();
    return false;
});

//Validate the reCaptcha and email fields and save the subscribed user details
$(".subscriber_email").val('');
$(document).on('click', '#subscribe', function () {
    let url = window.location.href.toString().split(window.location.host)[1];
    var subscriber_email = $(".subscriber_email").val();
    var valid = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(subscriber_email) && subscriber_email.length;
    if (!valid) {
        $('.email-validation').html((valid ? '' : '<b>Enter a valid email Address!!</b>')).show();
        return false;
    }
    if(url === '/contactus') {
        var response = grecaptcha.getResponse(1);
    } else {
        var response = grecaptcha.getResponse(0);
    }
    if (response.length === 0) {
        $('.email-validation').html('<b>Please verify the reCaptcha</b>').show();
        return false;
    }
    $.ajax({
        type: 'post',
        url: base_url + '/subscribe',
        data: {
            'email': subscriber_email,
            'g-recaptcha-response': response
        },
        success: function (res) {
            Swal.fire({
                icon: res.status,
                title: 'Subscribe',
                html: res.message,
                showDenyButton: false, showCancelButton: false,
                confirmButtonText: `Ok`,
            });
            $(".subscriber_email").val('');
        }
    })
    grecaptcha.reset();
});

//Hide the alert msg to verify the reCaptcha
function hideAlertMsg() {
    $('.email-validation').hide();
}

$(".subscriber_email").keypress(function (e) {
    if (e.which == 13 || e.keyCode == 13) {
        $("#subscribe").trigger('click')
        return true;
    }
})

