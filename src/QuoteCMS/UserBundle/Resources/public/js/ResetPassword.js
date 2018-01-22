function resetedModalSetControlsDisabled(disabled)
{
    var submit_reset_modal = $('#submit_reset_modal');
    submit_reset_modal.prop('disabled', disabled);
    $('#cancel_reset_modal').prop('disabled', disabled);
    $('#username_reset_modal').prop('readonly', disabled);
    if (disabled)
        submit_reset_modal.prepend(getLoadingCircle('ResetModalSubmitLogo'));
    else
        $("#ResetModalSubmitLogo").remove();
}

function resetedInWithAjax(data)
{
    var resetModalMessage = $("#resetModalMessage");
    resetModalMessage.fadeOut('slow', function(){
        resetModalMessage.html(getSucessDivbegin() +
            data["message"] +
        getEndDiv());
        resetModalMessage.fadeIn('slow');
        var cancel_reset_modal = $('#cancel_reset_modal');
        cancel_reset_modal.html("Fermer");
        cancel_reset_modal.prop('disabled', false);
    });
}

function errorResetedInWithAjax(data)
{
    var resetModalMessage = $("#resetModalMessage");
    resetModalMessage.fadeOut('slow', function(){
        resetModalMessage.html(getErrorDivBegin() +
        data["message"] +
        getEndDiv());
        resetModalMessage.fadeIn('slow');
        resetedModalSetControlsDisabled(false);
    });
}

function errorConnectionResetWithAjax()
{
    var resetModalMessage = $("#resetModalMessage");
    resetModalMessage.fadeOut('slow', function(){
        resetModalMessage.html(getConnectionErrorMessage());
        resetModalMessage.fadeIn('slow');
        resetedModalSetControlsDisabled(false);
    });
}

function breforeResetFormSubmit()
{
    // Dialog control
    resetedModalSetControlsDisabled(true);
    return true;
}

function resetFormSent(data)
{
    if(data["success"])
    {
        resetedInWithAjax(data);
    }
    else
    {
        errorResetedInWithAjax(data);
    }
}


function prepareModalResetFormAction()
{
    $("#form_reset_modal").ajaxForm({
        beforeSubmit:breforeResetFormSubmit,
        success:resetFormSent,
        error:errorConnectionResetWithAjax
    });
}

function showModalResetForm()
{
    if (!window.resetFormShown) {
        $.get( Routing.generate('fos_user_resetting_request'), function(data) {
            $( "body" ).append(data);
            window.resetFormShown = true;
            $('#resetModal').modal();
            prepareModalResetFormAction();
        });
    }
    else
        $('#resetModal').modal();
    return false;
}