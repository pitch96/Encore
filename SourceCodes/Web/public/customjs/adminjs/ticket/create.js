var room = 1;

function additional_fields() {
    room++;
    var objTo = document.getElementById('additional_fields')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass" + room);
    var rdiv = 'removeclass' + room;
    divtest.innerHTML =
        `<div class=" border border-5 mt-3 p-3">
            <div class="row ">
                <div class="col-10"><label class="create_event_head">Fill up the details</label></div>
                <div class="col-2">
                    <div class="input-group-btn"> 
                        <button class="btn btn-danger float-right" type="button" onclick="remove_additional_fields(` + room + `);"> 
                        <i class="fa-solid fa-circle-minus"></i> 
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                    <label class="create_event_head">Ticket Title</label>
                        <input type="text" name="ticket_title[]" maxlength="150"
                            class="form-control" required
                            placeholder="Ticket Title"
                            value="">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                    <label class="create_event_head">Ticket Type</label>
                        <select class="form-control select2bs4 choose-type"
                            data-count="` + room + `" style="width: 100%;" name="ticket_type[]" required>
                            <option value="">Choose ticket type</option>
                            <option value="Paid">Paid</option>
                            <option value="Free">Free</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                    <label class="create_event_head">Ticket Quantity</label>
                        <input type="number" name="total_qty[]" class="form-control quantity" required min="0" max="999999"
                            placeholder="Total Quantity"
                            value="">
                    </div>
                </div>
                <div class="col-sm-4" id="price_status` + room + `" style="display:none;">
                    <div class="form-group">
                    <label class="create_event_head">Ticket Price</label>
                        <input type="number" name="ticket_price[]" step="0.01" min="0" max="999999999"
                            class="form-control numbersOnly" id="validation` + room + `"
                            placeholder="Price per unit"
                            value="">
                    </div>
                </div>
            </div>
            <label class="create_event_head">Date & Time</label>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                    <label class="create_event_head"> End Date </label>
                    <i class="fa fa-calendar end_ticket" aria-hidden="true"></i>
                        <input type="text" name="end_date[]"  data-count="` + room + `" 
                            class="form-control endDate end-date-` + room + `"
                            value="" required readonly
                            placeholder="End date" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                    <label class="create_event_head">  End Time </label>
                        <input type="time" name="end_time[]" required
                            class="form-control end-time-` + room + `"  value=""  placeholder="End date" />
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            </div>
            
        </div>`;
        
    objTo.appendChild(divtest)
    $('.select2bs4').select2({
        theme: 'bootstrap4'
        }).on('select2:open', function(e){
        $('.select2-search__field').attr('placeholder', 'Search here...');
    });
    $('.quantity').mask('000000000');
    $('.numbersOnly').keyup(function () { 
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });
}

function remove_additional_fields(rid) {
    $('.removeclass' + rid).remove();
}

let end_date;
// let end_time;
end_date = $('.select_event :selected').data('end_date');
$('.endDate').datepicker( "option", "maxDate", end_date );
$('.endDate').datepicker( "option", "minDate", 0 );
$(document).on("change", ".select_event", function(){
    end_date = $('.select_event :selected').data('end_date');
    // end_time = $('.select_event :selected').data('end_time');
    $('.endDate').datepicker( "option", "maxDate", null );
    $('.endDate').datepicker( "option", "minDate", null );

    $('.endDate').datepicker( "option", "maxDate", end_date );
    $('.endDate').datepicker( "option", "minDate", 0 );
})

$(document).on('focus', ".endDate", function() {
    $(this).datepicker({
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        maxDate: end_date,
        dateFormat: 'yy-mm-dd'
    });
});

$(document).on('change', '.choose-type', function() {
    var count = $(this).data('count');
    var ticket_type = $(this).val();
    if (ticket_type == 'Paid') {
        $('#price_status' + count).show();
        $('#validation' + count).attr('required', true);
    } else {
        $('#price_status' + count).hide();
        $('#validation' + count).attr('required', false);
    }
})
