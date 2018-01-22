function showPostVideo(postNumber)
{
    var postVideoModal = $("#post_video_modal");
    if (typeof postVideoModal.html() != 'undefined')
    {
        postVideoModal.remove();
    }

    $.get( Routing.generate('quote_cms_ajax_post_video', {'post' : postNumber}), function(data) {
        $( "body" ).append(data);
        // WE MUST RENDER IT RESPONSIVE
        /*
        var videoIframe = $("#videoIframe");
        var videoHeight = $("#main_container").width() * 0.5625;
        videoIframe.height(videoHeight);
        */
        // Modal show up
        postVideoModal = $('#post_video_modal').modal();

        // For video WE MUST clean the modal else video will still play (sound lol)
        clearModalWhenHidden(postVideoModal);
    });
    return false;
}
