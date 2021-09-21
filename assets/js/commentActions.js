function postComment(button, postedBy, videoId, replyTo, containerClass) {
    var textarea = $(button).siblings("textarea");  // get textarea selected onclick button
    // siblings() is for get selected all elements previous and next of we are targeting one
    var commentText = textarea.val();
    textarea.val("");

    if(commentText) {

    }
    else{
        alert("You can not insert empty comment!");
    }
}