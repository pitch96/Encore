
var room = 1;
var count_array = [];

$(document).ready(function() {
    CKEDITOR.config.allowedContent = true;
    var editor = CKEDITOR.replace(document.querySelector('.description'), {
        language: 'en',
        extraPlugins: 'notification'
    });

    editor.on( 'required', function( evt ) {
        editor.showNotification( 'This field is required.', 'warning' );
        evt.cancel();
    } );
});

function additional_fields() {
    room++;
    count_array.push(room);
    if(count_array.length > 3){
        count_array.pop();
        return false;
    }
    var objTo = document.getElementById('additional_fields')
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass" + room);
    var rdiv = 'removeclass' + room;
    divtest.innerHTML =
            `<div class="row">
                <div class="col-sm-5">
                    <!-- textarea -->
                    <div class="form-group edt">
                        <label class="create_event_head"> Description</label>
                        <textarea name="description[]" class="form-control description` + room + `" required 
                            placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <div class="input-group">
                            <label class="create_event_head"> File Upload</label>
                            <div class="custom-file">
                                <input type="file" name="banner_image[]" onchange="gallery_photo_add(this);"
                                    class="custom-file-input" data-count="` + room + `" 
                                    accept="image/*" required>
                                <label class="custom-file-label mb-md-0"
                                    for="exampleInputFile">Choose file</label>
                            </div>
                            <div class="size_validation` + room + ` text-danger">  </div>
                        </div>
                        <br>
                        <div class="gallery` + room + `"> </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input-group-btn"> 
                        <button class="btn btn-danger" type="button" style="margin-top: 33px;" onclick="remove_additional_fields(` + room + `);"> 
                        <i class="fa-solid fa-circle-minus"></i> 
                        </button>
                    </div>
                </div>
            </div>`;

    objTo.appendChild(divtest);
    CKEDITOR.config.allowedContent = true;
    var editor = CKEDITOR.replace(document.querySelector('.description'+room), {
        language: 'en',
        extraPlugins: 'notification'
    });

    editor.on( 'required', function( evt ) {
        editor.showNotification( 'This field is required.', 'warning' );
        evt.cancel();
    } );
}

function remove_additional_fields(rid) {
    $('.removeclass' + rid).remove();
    count_array.pop();
}

function gallery_photo_add(event) {
    var count = event.getAttribute('data-count');
    if (typeof (FileReader) != "undefined") {
        var image_holder = $(".gallery" + count);
        var size_validation = $(".size_validation" + count);
        image_holder.empty();
        size_validation.empty();

        var reader = new FileReader();
        reader.onload = function (e) {
            // Get image URL.
            var imageURL = reader.result;
            // Get image size for image.
            getImageSize(imageURL, function(imageWidth, imageHeight) {
                // Do stuff here.
                if(imageWidth < 1920 || imageHeight < 850){
                    $(".size_validation" + count).html(`Banner must be greater then 1920*850px for better Look and feel.`);
                    event.value = '';
                }else{
                    $(".size_validation" + count).html('');
                    $("<img />", {
                        "src": e.target.result,
                        "class": "thumb-image",
                        "style": "height: 300px;width: 510px;"
                    }).appendTo(image_holder);
                }
            });
        }
        image_holder.show();
        reader.readAsDataURL(event.files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
}

function getImageSize(imageURL, callback) {      
    // Create image object to ascertain dimensions.
    var image = new Image();
 
    // Get image data when loaded.
    image.onload = function() {      
       // No callback? Show error.
       if (!callback) {
 
       // Yes, invoke callback with image size.
       } else {
          callback(this.naturalWidth, this.naturalHeight);
       }
    }
 
    // Load image.
    image.src = imageURL;
 }

