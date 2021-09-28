function postComment(button, postedBy, videoId, replyTo, containerClass) {
    var textarea = $(button).siblings("textarea");  // get textarea selected onclick button
    // siblings() is for get selected all elements previous and next of we are targeting one
    var commentText = textarea.val();
    textarea.val("");

    if(commentText) {
        // post ajax request
        $.post("ajax/postComment.php", {commentText: commentText, postedBy: postedBy, videoId: videoId, responseTo: replyTo})
            .done(function(comment) {

                $("."+containerClass).prepend(comment);

            });
    }
    else{
        alert("You can not insert empty comment!");
    }
}