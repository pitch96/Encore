jQuery(".at-title").click(function () {
    jQuery(this).toggleClass("active").next(".at-tab").slideToggle().parent().siblings().find(".at-tab").slideUp().prev().removeClass("active");
});

$("#payment-form").validate();
$("#billing_form").validate();

$(document).on('click', '.manage-quantity', function () {
    let manage_qty = $(this).data('value');
    let id = $(this).data('id');
    let price_per_head = parseFloat($(".price_per_head" + id).html());
    let ticket_qty = +$(".ticket_qty" + id).val();
    let quantity = +$(".total_no_of_ticket" + id).val();
    let ticket_id = +$(".ticket_id" + id).val();
    if (isNaN(quantity)) {
        Swal.fire({
            icon: 'warning',
            title: 'First select ticket type!',
            showDenyButton: false, showCancelButton: false,
            confirmButtonText: `Ok`,
        });
        return false;
    }
    if (manage_qty == 'plus') {
        if (ticket_qty < quantity) {
            $(".ticket_qty" + id).val(ticket_qty + 1);
        } else {
            Swal.fire({
                icon: 'warning',
                title: `You can only add ${quantity} tickets in this order`,
                showDenyButton: false, showCancelButton: false,
                confirmButtonText: `Ok`,
            });
            return false;
        }
    } else {
        if (ticket_qty > 1) {
            $(".ticket_qty" + id).val(ticket_qty - 1);
        } else {
            $(".ticket_qty" + id).val(1);
        }
    }
    ticket_qty = +$(".ticket_qty" + id).val();
    manageBuyTicket(id, price_per_head, ticket_qty, user_id, ticket_id);
})

$(document).on('change', '.input-qty', function () {
    let id = $(this).data('id');
    let price_per_head = parseFloat($(".price_per_head" + id).html());
    let ticket_qty = +$(".ticket_qty" + id).val();
    //let quantity = $(this).val();
    let quantity = +$(".total_no_of_ticket" + id).val();
    let ticket_id = +$(".ticket_id" + id).val();
    if (isNaN(quantity)) {
        Swal.fire({
            icon: 'warning',
            title: 'First select ticket type!',
            showDenyButton: false, showCancelButton: false,
            confirmButtonText: `Ok`,
        });
        return false;
    }
    if (ticket_qty > quantity) {
        Swal.fire({
            icon: 'warning',
            title: `You can only add ${quantity} tickets in this order`,
            showDenyButton: false, showCancelButton: false,
            confirmButtonText: `Ok`,
        });
        return false;
    }
    manageBuyTicket(id, price_per_head, ticket_qty, user_id, ticket_id);
})

function calculateTotal(submitType = 0) {
    var $total = '';
    var totalQuantity = 0;
    $("#cartTable").find('tr').each(function (e) {
        //console.log($(this).data('id'));
        var id = $(this).data('id');
        var price = parseFloat($(this).find('.price_per_head' + id).html());
        var quantity = parseInt($(this).find('.input-qty').val());
        totalQuantity = totalQuantity + quantity;
        $total = $total + (price * quantity);
    });

    $("#priceTxtx").html('Price (' + totalQuantity + ' items)');
    $(".sub_total").html('$' + $total);
    $(".total_amount").html('$' + $total);

    $.ajax({
        method: "get",
        url: base_url + "/calculateCart",
        success: function (response) {
            $("#cart_items").html(response.cart_items);
            if (submitType != undefined && submitType == 1) {
                submitPaidProcessing();
            } else if (submitType != undefined && submitType == 2) {
                submitFreeProcessing();
            }
        }
    });
}

function manageBuyTicket(id, price_per_head, ticket_qty, user_id, ticket_id) {
    $(".total_price" + id).html(price_per_head * ticket_qty);
    let data = {
        'user_id': +user_id,
        'ticket_id': ticket_id,
        'ticket_qty': ticket_qty,
    }
    $.ajax({
        method: "post",
        data: data,
        dataType: 'json',
        url: base_url + "/updateCartData",
        success: function (response) {
            if (response.status) {
                calculateTotal();
                //window.location.reload();
            }
        }
    });
}


// delete items fron cart
$(document).on('click', '.deleteTicket', function () {
    let cart_id = $(this).data('cart_id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "get",
                dataType: 'json',
                url: base_url + "/deleteCartItem/" + cart_id,
                success: function (response) {
                    if (response.status) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Cart data deleted successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((res) => {
                            if (res.isConfirmed) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        });
                    } else {
                        window.location.reload();
                    }
                }
            });
        } else {
            window.location.reload();
        }
    })

})

// Placed Order
$(document).on('click', '.place_order', function () {
    let cart_items = $("#cart_items").val();
    if (!cart_items) {
        Swal.fire(
            'Your cart is empty!',
            'Add items to it now.',
            'warning'
        )
        return false;
    }
    $("#faqhead1 a").removeClass('collapsed');
    $("#billing_address").addClass('show');
    $('html, body').animate({
        scrollTop: $(".accordionsection").offset().top
    }, 1000);
})

$(document).on("click", "#billing-data", function (e) {
    e.preventDefault();
    let cart_items = $("#cart_items").val();
    if (!cart_items) {
        Swal.fire(
            'Your cart is empty!',
            'Add items to it now.',
            'warning'
        )
        return false;
    }
    $("#faqhead1 a").addClass('collapsed');
    $("#billing_address").removeClass('show');

    if ($("#validationCustom11").val() == '') {
        $("#validationCustom11").siblings('.form-validation').show();
        return false;
    } else {
        $("#validationCustom11").siblings('.form-validation').hide();
    }
    if ($("#validationCustom02").val() == '') {
        $("#validationCustom02").siblings('.form-validation').show();
        return false;
    } else {
        $("#validationCustom02").siblings('.form-validation').hide();
    }
    if ($("#validationCustom03").val() == '') {
        $("#validationCustom03").siblings('.form-validation').show();
        return false;
    } else {
        $("#validationCustom03").siblings('.form-validation').hide();
    }
    if ($("#validationCustom04").val() == '') {
        $("#validationCustom04").siblings('.form-validation').show();
        return false;
    } else {
        $("#validationCustom04").siblings('.form-validation').hide();
    }
    if ($("#validationCustom05").val() == '') {
        $("#validationCustom05").siblings('.form-validation').show();
        return false;
    } else {
        $("#validationCustom05").siblings('.form-validation').hide();
    }
    if ($("#validationCustom10").val() == '') {
        $("#validationCustom10").siblings('.form-validation').show();
        return false;
    } else {
        $("#validationCustom10").siblings('.form-validation').hide();
    }

    $("#faqhead2 a").removeClass('collapsed');
    $("#payment_option").addClass('show');
    $('html, body').animate({
        scrollTop: $(".accordionsection").offset().top
    }, 1000);
})


function submitPaidProcessing() {
    var $form = $(".validation");
    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
    Stripe.createToken({
        number: $('#card_no').val(),
        cvc: $('#cvv').val(),
        exp_month: $('#month').val(),
        exp_year: $('#year').val()
    }, stripeHandleResponse);
}

function stripeHandleResponse(status, response) {
    let cart_items = $("#cart_items").val();
    if (!cart_items) {
        $("#buy_ticket").removeClass('not-active');
        Swal.fire(
            'Your cart is empty!',
            'Add items to it now.',
            'warning'
        )
        return false;
    }
    if (response.error) {
        $("#buy_ticket").removeClass('not-active');
        $('.error')
            .css('display', 'block')
            .find('.alert')
            .text(response.error.message);
    } else {
        $('.error').css('display', 'none');
        var token = response['id'];
        let billing_address = {};
        let total_price = $(".total_amount").html().replace("$", "");
        $('.billing_data').map(function () {
            let input_name = $(this).attr('name');
            billing_address[input_name] = this.value;
        });
        let data = {
            'user_id': +user_id,
            'cart_items': cart_items,
            'total_price': total_price,
            'billing_address': billing_address,
            'stripeToken': token
        }
        orderAjax(data);
    }
}


function submitFreeProcessing() {
    let cart_items = $("#cart_items").val();
    if (!cart_items) {
        $("#buy_ticket").removeClass('not-active');
        Swal.fire(
            'Your cart is empty!',
            'Add items to it now.',
            'warning'
        )
        showSubmitBtnText("purches_ticket", false);
        return false;
    }
    let billing_address = {};
    let total_price = $(".total_amount").html().replace("$", "");
    $('.billing_data').map(function () {
        let input_name = $(this).attr('name');
        billing_address[input_name] = this.value;
    });
    let data = {
        'user_id': +user_id,
        'cart_items': cart_items,
        'total_price': total_price,
        'billing_address': billing_address
    }        
    orderAjax(data);
    showSubmitBtnText("purches_ticket", false);
}


function showSubmitBtnText(controlId, isProcessing) {
    let control_id = $("#" + controlId);
    if (isProcessing) {
        control_id.html("Processing...");
    } else {
        control_id.html("Place Order");
    }

}
function orderAjax(data) {
    $.ajax({
        method: "POST",
        dataType: 'json',
        url: base_url + "/placed/order",
        data: data,
        success: function (response) {
            Swal.fire({
                title: 'Order Status',
                text: response.message,
                icon: response.status,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (response.status == "success") {
                        window.location.href = base_url;
                    } else {
                        window.location.reload();
                    }
                }
            })
        }
    });
}

$(function () {
    $('form.validation').bind('submit', function (e) {
        showSubmitBtnText("buy_ticket", true);
        $("#buy_ticket").addClass('not-active');
        var $form = $(".validation");
        if (!$form.data('cc-on-file')) {
            e.preventDefault();
            if ($("#payment-form").valid() && $("#billing_form").valid()) {
             calculateTotal(1);
            }
        }
        showSubmitBtnText("buy_ticket", false);
    });  

    
    $(document).on('click', '#purches_ticket', function (e) {
        showSubmitBtnText("purches_ticket", true);
        e.preventDefault();
        if (!$("#billing_form").valid()) {
            showSubmitBtnText("purches_ticket", false);
            return;
        }
        calculateTotal(2);
    })

});