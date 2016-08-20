$(document).ready(function() {
    $(".successMessage, .infoMessage, .errorMessage").click(function () {
        $(".errorMessage").fadeOut();
    });

    setTimeout(function(){
        $(".successMessage, .infoMessage, .errorMessage").fadeOut(); }, 3000);

});