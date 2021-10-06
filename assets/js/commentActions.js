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

function toggleReply(button) {
    let parent = $(button).closest(".itemContainer");
    let commentForm = parent.find(".commentForm").first();
    commentForm.toggleClass('hidden');
}

function likeComment(commentId, button, videoId) {
    $.post("ajax/likeComment.php",{commentId: commentId, videoId: videoId})
        .done(function(data){

            var likeButton = $(button);
            var dislikeButton = $(button).siblings(".dislikeButton");

            likeButton.addClass("active");
            dislikeButton.removeClass("active");

            var result = JSON.parse(data);

            updateLikesValue(likeButton.find(".text"), result.likes);
            updateLikesValue(dislikeButton.find(".text"), result.dislikes);

            if(result.likes < 0){
                likeButton.removeClass("active");
                likeButton.find('img:first').attr('src','assets/images/icons/thumb-up.png');
            }
            else{
                likeButton.find('img:first').attr('src','assets/images/icons/thumb-up-active.png');
            }

            dislikeButton.find('img:first').attr('src','assets/images/icons/thumb-down.png');

    });
}

function dislikeComment(commentId, button, videoId) {

}