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

function gallery_photo_add(event) {
    if (typeof(FileReader) != "undefined") {
        var image_holder = $(".gallery");
        image_holder.empty();

        var reader = new FileReader();
        reader.onload = function(e) {
            var imageURL = reader.result;
            // Get image size for image.
            getImageSize(imageURL, function(imageWidth, imageHeight) {
                // Do stuff here.
                if(imageWidth < 1920 || imageHeight < 850){
                    $(".size_validation1").html(`Banner must be greater then 1920*850px for better Look and feel.`);
                    event.value = '';
                }else{
                    $(".size_validation1").html('');
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