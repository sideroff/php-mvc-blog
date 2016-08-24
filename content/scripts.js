//load whole document then start executing script 
//so we don't access elements that are not yet loaded
$(document).ready(function() {
    $popups = $('div')
            .filter(function() {
                return  this.className.match(/(?:^info|^error|^success)Message$/);
        });
    $popups.click(function () {
        $(this).fadeOut();
    });
    $popups.each(function (index, value) {
        setTimeout(function () {
            $(value).fadeOut();
        },$(value).attr("data-timeout"))
    });
});
