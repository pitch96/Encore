var startdate = $("#startDate").val();
var enddate = $("#endDate").val();
// Set the date we're counting down to
var current_timestamp = new Date().getTime();
var start_timestamp = new Date(startdate).getTime();
var end_timestamp = new Date(enddate).getTime();
var status = '';
var countDownDate = '';
if (start_timestamp <= current_timestamp && end_timestamp >= current_timestamp) {
    status = 'Running';
}else if (start_timestamp > current_timestamp) {
    status = 'Upcoming';
    countDownDate = start_timestamp;
}else if (end_timestamp < current_timestamp) {
    status = 'Expired';
}else{
    status = 'not found';
}
// Update the count down every 1 second
var x = setInterval(function () {

    // Get today's date and time
    var now = new Date().getTime();

    if (status == "Upcoming") {
        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        $("#days").html(days);
        $("#hours").html(hours);
        $("#minutes").html(minutes);
        $("#seconds").html(seconds);

    }else{
        clearInterval(x);
        $("#countdown").html("<h3 class='text-white text-center ' style='padding: 10px'>Event " + status + " right now.</h3>")
    }
}, 1000);

$(document).on('click', '.manage-quantity', function(){
    var manage_qty = $(this).data('value');
    var ticket_qty = parseInt($(".ticket_qty").val(), 10);
    var quantity = parseInt($('.ticket_type').find(":selected").data('quantity'), 10);

    
    if(isNaN(quantity)){
        Swal.fire({  
            icon: 'warning',
            title: 'Please first select ticket type!',  
            showDenyButton: false,  showCancelButton: false,  
            confirmButtonText: `Ok`, 
        });
        return false;
    }

   
    if(manage_qty == 'plus'){
        if(ticket_qty < quantity){
            $(".ticket_qty").val(ticket_qty + 1);
            ticket_qty = parseInt($(".ticket_qty").val(), 10);
            $(".remaining_tickets").html(+$(".remaining_tickets").html()-1);
        }else{
            Swal.fire({  
                icon: 'warning',
                title: `No more ticket available`,  
                showDenyButton: false,  showCancelButton: false,  
                confirmButtonText: `Ok`, 
            });
            return false;
        }
    }else{
        if(ticket_qty > 1){
            $(".ticket_qty").val(ticket_qty-1);
            $(".remaining_tickets").html(+$(".remaining_tickets").html()+1);
        }else{
            $(".ticket_qty").val(1);
        }
    }
    ticket_qty = parseInt($(".ticket_qty").val(), 10);
    var ticket_type = $('.ticket_type').find(":selected").data('ticket_type');
    var price = parseFloat($('.ticket_type').find(":selected").data('price'));
    manageBuyTicket(ticket_qty, ticket_type, price);
})


$(document).on("change",'.ticket_type', function(){
    $(".ticket_qty").val(1);
    var ticket_qty = parseInt($(".ticket_qty").val(), 10);
    var ticket_type = $('.ticket_type').find(":selected").data('ticket_type');
    var quantity = parseInt($('.ticket_type').find(":selected").data('quantity'), 10);
    var price = parseFloat($('.ticket_type').find(":selected").data('price'));
    $(".remaining_tickets").html(quantity - ticket_qty);
    if(ticket_qty < quantity){
        manageBuyTicket(ticket_qty, ticket_type, price);
    }else{
        return false;
    }
})

function manageBuyTicket(ticket_qty, ticket_type, price){
    if(ticket_type != undefined){
        if(ticket_type == "Free"){
            $(".price_per_head").html("$ 0");
            $(".total_price").html("$ 0");
        }else{
            $(".price_per_head").html("$ " + price.toFixed(2));
            $(".total_price").html("$ " + (price * ticket_qty).toFixed(2));
        }
    }else{
        $(".price_per_head").html("$ 0");
        $(".total_price").html("$ 0");
    }
}

$(document).on('click', '.buy_ticket', function(){
    let ticket_id = $(".ticket_type").val();
    let ticket_qty = $(".ticket_qty").val();
    let remaining_tickets = $('.span_details .remaining_tickets').text();
    if(!user_id){
        Swal.fire({
            title: '<strong>Please login or register first!</strong>',
            icon: 'warning',
            html:
              `if you have already registered user then please
              <a href='${base_url}/login'>login</a> and if you are not a register user
              then please first <a href='${base_url}/register'>register</a> your self and then login.`,
            showCloseButton: false,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonText: 'Ok',
          })
        return false;
    }
    if(!ticket_id){
        Swal.fire({  
            icon: 'warning',
            title: 'Ticket Type Error',  
            html: `First select ticket type.`,
            showDenyButton: false,  showCancelButton: false,  
            confirmButtonText: `Ok`, 
        });
        return false;
    }
    if(remaining_tickets < 0){
        Swal.fire({  
            icon: 'warning',
            title: 'Available Ticket Error',  
            html: `No More Ticket Available!`,
            showDenyButton: false,  showCancelButton: false,  
            confirmButtonText: `Ok`, 
        });
        return false;
    }
    let data = {
        'user_id': user_id,
        'ticket_id': ticket_id,
        'ticket_qty': ticket_qty,
        'remaining_tickets': remaining_tickets,
    }
    $.ajax({
        method: "POST",
        dataType: 'json',
        url: base_url + "/AddToCart",
        data:data,
        success: function (response) {
            if(response.status){
                // similar behavior as an HTTP redirect
                window.location.replace(`${base_url}/checkout`);
            }
        }
    });
})
