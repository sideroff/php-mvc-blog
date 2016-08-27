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
    
    $('.show-change-avatar-form').click(function () {
        if(!$('.change-avatar-form').is(':visible')){
            $('.change-avatar-form').show();
            $('.show-change-avatar-form').html('Hide form');
        }
        else{
            $('.change-avatar-form').hide();
            $('.show-change-avatar-form').html('Change avatar');
        }
        
    })

});
