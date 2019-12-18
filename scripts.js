// When uploading an image this will display the preview of that image on        new_post.php

function uploadPost() {
    document.querySelector('#uploadedImage').click();
}

function displayImage(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            document.querySelector('#postDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}




// edit_porfile.php

function uploadPost() {
    document.querySelector('#uploadedProfile').click();
}

function displayProfile(e) {
    if (e.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}








// On click of THIS div with the ID clickContainer with the classed on d-none
// if found class d-none remove it from the 2 pieces

// if i click a diffrent one add the class back to the one that it just removed it from
// if i click on the body add the class back to the one i just removed it from


var hasBeenClicked = false;

$('.clickContainer .postPhoto').click(function( e ) {

    hasBeenClicked = true;

    e.preventDefault();
    
    $(this).parent().find(".nameLocation, .commentSection").slideToggle();
    
});


// share comment button prevent default so when i share a comment it doesnt reload the page


// $( ".commentButton" ).click(function( e ) {

//     e.preventDefault();

// }







// Show comments

var showComments = false

$( ".showComments" ).click(function( e ) {
    e.preventDefault();
    // on click on show comments button select the ul [with and id ^that starts with = comment block] .toggle style display none

    var comment_block = $(this).data("comment_block");
    $(comment_block).slideToggle();

    

    showComments = true;

    // $(this).closest("ul").find("comment_block3").toggle();

    // console.log(this);

    

});




