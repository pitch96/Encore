$("#fileUpload").on('change', function () {

    if (typeof (FileReader) != "undefined") {

        var image_holder = $("#image-holder");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<img />", {
                "src": e.target.result,
                "class": "thumb-image"
            }).appendTo(image_holder);

        }
        image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
});
$("#fileUpload2").on('change', function () {

    if (typeof (FileReader) != "undefined") {

        var image_holder = $("#image-holder2");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            $("<img />", {
                "src": e.target.result,
                "class": "thumb-image"
            }).appendTo(image_holder);

        }
        image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
});

startDate = $("#startDate").datepicker({
    changeMonth: true,
    changeYear: true,
    minDate: 0,
    dateFormat: 'yy-mm-dd'
})
.on("change", function () {
    endDate.datepicker("option", "minDate", getDate(this));
}),

endDate = $("#endDate").datepicker({
    changeMonth: true,
    changeYear: true,
    minDate: $("#startDate").val(),
    dateFormat: 'yy-mm-dd'
})
.on("change", function () {
    startDate.datepicker("option", "maxDate", getDate(this));
});

function getDate(element) {
    var date;
    var dateFormat = 'yy-mm-dd';
    try {
        date = $.datepicker.parseDate(dateFormat, element.value);
    } catch (error) {
        date = null;
    }

    return date;
}
