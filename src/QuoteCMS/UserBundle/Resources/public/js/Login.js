const oAuthRedirectCookie = "OAuth_r";

// remove unused cookie when page change
function removeOAuthRedirectCookie()
{
    if ($.cookie(oAuthRedirectCookie))
    {
        $.removeCookie(oAuthRedirectCookie, {
            path: '/',
            secure: true
        });
    }
}

function checkCookieRedirectBeforeChangePage()
{
    $(window).bind('beforeunload', function(){
        // Check if guys clicked on
        if (!window.oAuthButtonClicked)
        {
            removeOAuthRedirectCookie();
        }
    });
}

function oAuthLoginClick()
{
    window.oAuthButtonClicked = true;
    return true;
}

function prepareOAuthLogin()
{
    $.cookie(oAuthRedirectCookie, $(location).attr('href'), {
        path: "/",
        secure: true
    });
}

function cancelOAuthLoginWhenHide(modal)
{
    modal.on('hidden.bs.modal', function (e) {
        removeOAuthRedirectCookie();
    });
}

function loginModalSetControlsDisabled(disabled)
{
    var submit_login_modal = $('#submit_login_modal');
    submit_login_modal.prop('disabled', disabled);
    $('#cancel_login_modal').prop('disabled', disabled);
    $('#close_login_shown_register_modal').prop('disabled', disabled);
    $('#username_modal').prop('readonly', disabled);
    $('#password_modal').prop('readonly', disabled);
    $('#remember_me_modal').prop('hidden', disabled);
    if (disabled)
        submit_login_modal.prepend(getLoadingCircle("ModalSubmitLogo"));
    else
        $("#ModalSubmitLogo").remove();
}

function logedInWithAjax()
{
    var loginModalMessage = $("#loginModalMessage");
    loginModalMessage.fadeOut('slow', function(){
        loginModalMessage.html(getSucessDivbegin() + 'Connecté' +getEndDiv());
        loginModalMessage.fadeIn('slow');
        //removeOAuthRedirectCookie();
        window.loggedIn = true;
        refreshUserBar();
        refreshCommentDiv();
        setTimeout("$('#loginModal').modal('hide');", 1000);
        // TODO : Forum auto login
        //$.get("https://forum.gamers-life.wtf/session/sso");
    });
}

function errorLogedInWithAjax(data)
{
    //$("#login_cssf_modal").val(data["csrf"]);
    var loginModalMessage = $("#loginModalMessage");
    loginModalMessage.fadeOut('slow', function(){
        loginModalMessage.html(getErrorDivBegin() + data["message"] +
            getEndDiv());
        loginModalMessage.fadeIn('slow');
        loginModalSetControlsDisabled(false);
    });
}

function errorConnectionLoginWithAjax()
{
    var loginModalMessage = $("#loginModalMessage");
    loginModalMessage.fadeOut('slow', function(){
        loginModalMessage.html(getConnectionErrorMessage());
        loginModalMessage.fadeIn('slow');
        loginModalSetControlsDisabled(false);
    });
}

function beforeLoginFormSubmit()
{
    loginModalSetControlsDisabled(true);
    return true;
}

function loginFormSent(data)
{
    if(data["success"])
    {
        logedInWithAjax();
    }
    else
    {
        errorLogedInWithAjax(data);
    }
}

function prepareModalLoginFormAction()
{
    $("#form_login_modal").ajaxForm({
        beforeSubmit:beforeLoginFormSubmit,
        success:loginFormSent,
        error:errorConnectionLoginWithAjax
    });
}

function loginModalLoad()
{
    var modalLogin = $('#loginModal').modal();
    prepareOAuthLogin();
    return modalLogin;
}

function showModalLoginForm()
{
    if (!window.loginFormShown) {
        $.get( Routing.generate('fos_user_security_login'), function(data) {
            $( "body" ).append(data);
            window.loginFormShown = true;
            cancelOAuthLoginWhenHide(loginModalLoad());
            prepareModalLoginFormAction();
        });
    }
    else
        loginModalLoad();

    return false;
}
