
function registerModalSetControlsDisabled(disabled)
{
    var submit_register_modal = $('#submit_register_modal');
    submit_register_modal.prop('disabled', disabled);
    $('#cancel_register_modal').prop('disabled', disabled);
    $('#close_register_show_login_modal').prop('disabled', disabled);
    $('#username_register_modal').prop('readonly', disabled);
    $('#email_register_modal').prop('readonly', disabled);
    $('#register_first_password_modal').prop('readonly', disabled);
    $('#register_second_password_modal').prop('readonly', disabled);
    if (disabled)
        submit_register_modal.prepend(getLoadingCircle('ModaRegisterlSubmitLogo'));
    else
        $("#ModaRegisterlSubmitLogo").remove();
}

function registerFadeOutAllMessages(functionThen)
{
    $("#registerModalMessage").fadeOut('slow');
    $("#registerUsernarmeErrorModal").fadeOut('slow');
    $("#registerEmailErrorModal").fadeOut('slow');
    $("#registerPasswordErrorModal").fadeOut('slow', functionThen);
}

function errorRegistredWithAjax(dataError)
{
    //$(".register_csrf_class_modal").val(dataError["csrf"]);
    registerFadeOutAllMessages(function()
    {
        if (dataError.hasOwnProperty('usernameError'))
        {
            var registerUsernarmeErrorModal = $("#registerUsernarmeErrorModal");
            registerUsernarmeErrorModal.html(
                getErrorDivBegin() + dataError["usernameError"] +
                getEndDiv());
            registerUsernarmeErrorModal.fadeIn('slow');
        }
        if (dataError.hasOwnProperty('emailError'))
        {
            var registerEmailErrorModal = $("#registerEmailErrorModal");
            registerEmailErrorModal.html(
                getErrorDivBegin() + dataError["emailError"] +
                getEndDiv());
            registerEmailErrorModal.fadeIn('slow');
        }
        if (dataError.hasOwnProperty('passwordError'))
        {
            var registerPasswordErrorModal = $("#registerPasswordErrorModal");
            registerPasswordErrorModal.html(
                getErrorDivBegin() + dataError["passwordError"] +  getEndDiv());
            registerPasswordErrorModal.fadeIn('slow');
        }
        registerModalSetControlsDisabled(false);
    });
}

function errorConnectionRegisterWithAjax()
{
    registerFadeOutAllMessages(function(){
        var registerModalMessage = $("#registerModalMessage");
        registerModalMessage.html(getConnectionErrorMessage());
        registerModalMessage.fadeIn('slow');
        registerModalSetControlsDisabled(false);
    });
}

function registeredWithAjax(data)
{
    registerFadeOutAllMessages(function()
    {
        var registerModalMessage = $("#registerModalMessage");
        registerModalMessage.html(getSucessDivbegin() + data["message"] +
        getEndDiv());
        registerModalMessage.fadeIn('slow');
        if (data["mailConfirmation"])
        {
            removeOAuthRedirectCookie();
            setTimeout("$('#registerModal').modal('hide');", 10000); // 10 seconds to be readable
        }
        else
        {
            window.loggedIn = true;
            refreshUserBar();
            //removeOAuthRedirectCookie();
            refreshCommentDiv();
            setTimeout("$('#registerModal').modal('hide');", 2000);
        }
    });
}

function beforeRegistrationFormSubmit()
{
    registerModalSetControlsDisabled(true);
    return true;
}

function registerFormSent(data)
{
    if(data["success"])
    {
        registeredWithAjax(data);
    }
    else
    {
        errorRegistredWithAjax(data);
    }
}

function prepareModalRegisterFormAction()
{
    $("#form_register_modal").ajaxForm({
        beforeSubmit:beforeRegistrationFormSubmit,
        success:registerFormSent,
        error:errorConnectionRegisterWithAjax
    });
}

function registerModalLoad()
{
    var modalRegister = $('#registerModal').modal();
    prepareOAuthLogin();
    return modalRegister;
}

function showModalRegisterForm()
{
    if (!window.registerFormShown) {
        $.get( Routing.generate('fos_user_registration_register'), function(data) {
            $( "body" ).append(data);
            window.registerFormShown = true;
            cancelOAuthLoginWhenHide(registerModalLoad());
            prepareModalRegisterFormAction();
        });
    }
    else
        registerModalLoad();
    return false;
}
