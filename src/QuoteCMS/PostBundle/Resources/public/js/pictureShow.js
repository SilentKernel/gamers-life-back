function showPostPicture(slug, imgNumber)
{
    var postPictureModal = $("#post_screenshot_modal");
    if (typeof postPictureModal.html() != 'undefined')
    {
        postPictureModal.remove();
    }
        $.get( Routing.generate('quote_cms_ajax_post_picture', {'postSlug' : slug, 'imgNumber' : imgNumber}), function(data) {
            $( "body" ).append(data);
            postPictureModal = $('#post_screenshot_modal').modal();
            clearModalWhenHidden(postPictureModal);
        });
    return false;
}