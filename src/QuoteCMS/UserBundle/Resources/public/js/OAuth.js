function OAuthRememberMe()
{
    $.get( Routing.generate('quote_cms_user_oauth_remember_me'), function(data) {
        if (data["success"])
        {
            var OAuthRememberMeMessage = $("#OAuthRememberMeMessage");
            OAuthRememberMeMessage.fadeOut('slow', function(){
                OAuthRememberMeMessage.html('<span class = "text-success">Activé</span>');
                OAuthRememberMeMessage.fadeIn('slow');
            });
        }
    });
    return false;
}