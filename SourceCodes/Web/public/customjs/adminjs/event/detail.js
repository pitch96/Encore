var startdate = $("#startDate").val();
// var starttime = $("#startTime").val();
var enddate = $("#endDate").val();
// var endtime = $("#endTime").val();
// Set the date we're counting down to
var current_timestamp = new Date().getTime();
var start_timestamp = new Date(startdate).getTime();
var end_timestamp = new Date(enddate).getTime();
var status = '';
var countDownDate = '';
if (start_timestamp <= current_timestamp && end_timestamp >= current_timestamp) {
    status = 'Running';
}
if (start_timestamp > current_timestamp) {
    status = 'Upcoming';
    countDownDate = start_timestamp;
}
if (end_timestamp < current_timestamp) {
    status = 'Expired';
}
// alert(status);
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

        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = "<span class='text-bold'> Event starting in :- </span> " + days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";

    }
    // If the count down is finished, write some text
    if (status == "Expired") {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "Event " + status + " right now.";
    }
    if (status == "Running") {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "Event " + status + " right now.";
    }
}, 1000);



$(document).on('click', '.refer_event', function(){
    let event_id = $(this).data('event_id');
    let stripe_account = $(this).data('stripe_account');
    let loggedin_id = $("#loggedin_id").val();
    if(stripe_account == '' && user_id != 1){
        Swal.fire({
            icon: 'warning',
            title: 'Connect with stripe account',
            html: 'First you need to connect with stripe account for accepting the payment. For create stripe account click on <a href="'+base_url+'/admin/stripe/account">here</a> ',
            showCancelButton: false,
            confirmButtonText: 'Ok',
        }).then((result) => {
            window.location.reload();
        })
        return false;
    }
    Swal.fire({
        icon: 'warning',
        title: 'Refer this event with your friends and get some referral amount.',
        input: 'text',
        inputValue : base_url+'/event/detail/'+event_id+'/'+loggedin_id,
        inputAttributes: {
          autocapitalize: 'off',
          readonly: 'true',
          color:'white'
        },
        showCancelButton: true,
        confirmButtonText: 'Copy',
      }).then((result) => {
        if (result.isConfirmed) {
            var clipboardText = "";
            clipboardText = result.value;
            copyToClipboard( clipboardText );
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: "Your referral url copied successfully.",
                timer: 2000,
                showCancelButton: false,
                showConfirmButton: false
              })
        }
      })
});

function copyToClipboard(text) {
    var textArea = document.createElement( "textarea" );
    textArea.value = text;
    document.body.appendChild( textArea );

    textArea.select();

    try {
       var successful = document.execCommand( 'copy' );
       var msg = successful ? 'successful' : 'unsuccessful';
    } catch (err) {   

    }
    document.body.removeChild( textArea );
 }

 $(document).on('click', ".get-access", function(){
    let event_id = $(this).data('event_id');
    let event_created_by = $(this).data('event_created_by');
    let data = {
        event_id: event_id,
        event_created_by: event_created_by,
    };
    $.ajax({
        method: "POST",
        dataType: 'json',
        url: base_url + "/admin/promoter/access",
        data:data,
        success: function (response) {
            if(response.status){
                Swal.fire({  
                    icon: 'success',
                    title: 'Promotion Access',  
                    html: response.message,
                    showDenyButton: false,  showCancelButton: false,  
                    confirmButtonText: `Ok`, 
                }).then(function() {
                    window.location.reload();
                });
            }
        }
    });
 });