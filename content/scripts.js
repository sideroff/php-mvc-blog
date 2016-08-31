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

function vote(boolVote, comment_id, voter_id, url) {
    $.ajax({
        type: "POST",
        url: url,
        data:
        {
            boolVote: boolVote,
            comment_id: comment_id,
            voter_id: voter_id
        }
    }).done(function( msg ) {
        objects = msg.split("|");
        upvotes = JSON.parse(objects[0]);
        downvotes = JSON.parse(objects[1]);

        upvotes_length = upvotes.length;
        downvotes_length = downvotes.length;

        if(upvotes_length == undefined){
            upvotes_length=0;
        }
        if(downvotes_length == undefined){
            downvotes_length=0;
        }

        if(upvotes['user_voted']){
            $.each( upvotes, function() {
                upvotes_length++;
            });
            upvotes_length--;
            $("#"+comment_id+".upvote").prop('disabled', true);
            $("#"+comment_id+".downvote").prop('disabled', false);
        }
        else if(downvotes['user_voted']){
            $.each( downvotes, function() {
                downvotes_length++;
            });

            downvotes_length--;
            $("#"+comment_id+".downvote").prop('disabled', true);
            $("#"+comment_id+".upvote").prop('disabled', false);
        }

        $("#"+comment_id+".upvotes").html(upvotes_length);
        $("#"+comment_id+".downvotes").html(downvotes_length)
    })
}