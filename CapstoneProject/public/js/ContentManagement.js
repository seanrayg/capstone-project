function readURL(input, holder) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(holder).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$( document ).ready(function() {
    $("#HomePageHeader").change(function(){
        readURL(this, '#HomePagePicture');
    });
    $("#HomeBodyImage1").change(function(){
        readURL(this, '#HomeBodyPicture1');
    });
    $("#HomeBodyImage2").change(function(){
        readURL(this, '#HomeBodyPicture2');
    });
    $("#HomeBodyImage3").change(function(){
        readURL(this, '#HomeBodyPicture3');
    });
    
    $("#AccommodationHeader").change(function(){
        readURL(this, '#AccommodationPicture');
    });
    
    $("#PackagesHeader").change(function(){
        readURL(this, '#PackagesPicture');
    });
    
    $("#ActivitiesHeader").change(function(){
        readURL(this, '#ActivitiesPicture');
    });
    
    $("#ContactsHeader").change(function(){
        readURL(this, '#ContactsPicture');
    });
    
    $("#LocationHeader").change(function(){
        readURL(this, '#LocationPicture');
    });
    
    $("#LocationBody").change(function(){
        readURL(this, '#LocationBodyPicture');
    });
    
    $("#AboutUsHeader").change(function(){
        readURL(this, '#AboutUsPicture');
    });
});


function ShowInputFile(id){
    document.getElementById(id).style.display = "block";
}