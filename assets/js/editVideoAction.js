function setNewThumbnail(thumbnailId, videoId, itemElement) {
    $.post("ajax/updateThumbnail.php", {video_id: videoId, thumbnail_id: thumbnailId})
        .done(function(data) {
            var item = $(itemElement);
            var itemClass = item.attr("class");

            $("." + itemClass).removeClass("selected");

            item.addClass("selected");
            alert("Thumbnail updated");
            console.log(data);
        });
}