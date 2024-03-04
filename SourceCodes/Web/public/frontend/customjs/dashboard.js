$(document).ready(function () {
        $("#title").autocomplete({
            source: function (request, response) {
                $.ajax({
                    method:'get',
                    url: base_url + "/autocomplete/",
                    data: {
                        title: request.term
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.length) {
                            var resp = $.map(data, function (obj) {
                                return obj.event_title;
                            });
                        } else {
                            var resp = ["No Record Found"];
                        }
    
                        response(resp);
                    }
                });
            },
            minLength: 1
        });

});

$(document).on("click", ".filter-by-category", function () {
    var $this = $(this);
    var category_id = $this.data('category');
    $.ajax({
        url: base_url + "/search/events/" + category_id,
        success: function (data) {
            $(".all-events").html('');
            $('.filter-by-category').removeClass('is-checked');
            $this.addClass('is-checked');
            if (data) {
                $(".filter-events").html(data);
            } else {
                $(".filter-events").html('<h2 class="text-white">No Record Found!</h2>');
            }
        }
    });
});

$(document).on("click", ".filterEvents", function(e){
    e.preventDefault();
    var category_id = $("#category_id").val();
    var event_title = $("#event_title").val();
    
    $.ajax({
        method: "get",
        data: {
            category_id:category_id,
            title:event_title
        },
        url: base_url + "/filter/events",
        success: function(data){
            $(".all-events").html('');
            if (data) {
                $(".filter-events").html(data);
            } else {
                $(".filter-events").html('<h2 class="text-white">No Record Found!</h2>');
            }
        }
    });
})

// Showing QR Codes for all orders Start
function showQrCodes(event_id){
    var id = event_id;
    var objTo = document.getElementById('showTicketsForMyOrders');
    var btnData = document.getElementById('paginationBtn');
    var renderQR = document.getElementById('qrRender');
    renderQR.innerHTML = '';
    var pageNum = document.getElementById('page_num').value;
    if (!pageNum || pageNum == 0) {
        pageNum = 1
    }
    btnData.innerHTML = '';
    objTo.innerHTML = '';
    var eventName = document.getElementById('event_name');
    var eventStartDate = document.getElementById('event_start-date');
    var eventEndDate = document.getElementById('event_end-date');
    eventName.innerHTML = '';
    btnData.innerHTML = `
                         <button onclick="loadPrevPageData(`+id+`)" style="margin: 2px" type="button" id="prevBtn" class="btn-search">Prev</button>
                         <button onclick="loadnextPageData(`+id+`)" type="button" class="btn-search" id="nxtBtn" value="2">Next</button>
                        `;
    $.ajax({
        method: "POST",
        url: base_url + "/showQRs/" + id,
        data: {
            pageNum: pageNum
        },
        success: function(res){
            document.getElementById('page_num').value = res.page_number;

            if (res.last_page == true && res.page_number == 1) {
                document.getElementById("prevBtn").disabled = true;
                document.getElementById("nxtBtn").disabled = true;
            } else if (res.page_number == 1) {
                document.getElementById("prevBtn").disabled = true;
            } else if (res.last_page == true) {
                document.getElementById("nxtBtn").disabled = true;
            } else if (res.qr.length < 5) {
                document.getElementById("nxtBtn").disabled = true;
            }

            if(document.getElementById("prevBtn").disabled) {
                document.getElementById("prevBtn").classList.add('disabledBtn');
            }
            if(document.getElementById("nxtBtn").disabled) {
                nBtn = document.getElementById("nxtBtn").classList.add('disabledBtn');
            }

            let x = JSON.parse(res.qr[0].order_data.order_details);
            eventName.innerHTML = x.event_title;
            eventStartDate.innerHTML = `Starting From: <b>`+x.event_start_date+`</b> At <b>`+x.event_start_time+`</b>`;
            eventEndDate.innerHTML = `Ends On: <b>`+x.event_end_date+`</b> At <b>`+x.event_end_time+`</b>`;
            for(let xx in res.qr){
                let x = parseInt(xx);
                objTo.innerHTML += `<div class="input-field second-wrap float-left row" style="margin-right: 1px; margin-top: 8px;">
                                         <button type="button" onclick="openQR('`+res.qr[xx].ticket_no+`');" class="btn-search">
                                             `+(x+1)+`
                                             <i class="fa fa-qrcode" aria-hidden="true" style="margin-left: 2px;"></i>
                                         </button>
                                     </div>`;
            }
        }
    });
}
// Showing QR Codes for all orders End

// Prev Pagination Function Start
function loadPrevPageData(order_id){
    var pageNumber = document.getElementById('page_num').value;
    document.getElementById('page_num').value = pageNumber - 1;
    var renderQR = document.getElementById('qrRender');
    renderQR.innerHTML = '';
    showQrCodes(order_id);
}
// Prev Pagination Function End

// Next Pagination Function Start
function loadnextPageData(order_id){
    var pageNumber = document.getElementById('page_num').value;
    document.getElementById('page_num').value = parseInt(pageNumber) + 1;
    var renderQR = document.getElementById('qrRender');
    renderQR.innerHTML = '';
    showQrCodes(order_id);
}
// Next Pagination Function End

// Rendering QR code in Modal Pop-up Start
function openQR(ticket){
    var ticket_no = ticket;
    var renderQR = document.getElementById('qrRender');
    renderQR.innerHTML = `
                            <center>
                                <img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chld=L|0&chl=`+ticket_no+`" alt="Thubnail" />
                             </center>
                             <h5 class="profile-barcode-text">`+ticket_no+`</h5>
                             `;
}
// Rendering QR code in Modal Pop-up End

// Showing event cancelled notification on click of orders Start
function cancelNotification(id){
    let order_id = id;
    $.ajax({
        method: "GET",
        url: base_url + "/order/cancellation/details/" + order_id,
        success: function(response) {
            Swal.fire({
                title: "Event was cancelled!",
                text: response.message,
                icon: 'error',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#3085d6',
                showCancelButton: false
            })
        }
    });
}
// Showing event cancelled notification on click of orders End
