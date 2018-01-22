function refreshAvatarSection()
{
    $.get (Routing.generate('quote_cms_user_avatar_section'),function(data)
    {
        $("#profilEditAvatarSection").html(data);
    });
}

function avatarUploadModalSetControlsDisabled(disabled)
{
    $('#submit_avatar_upload_modal').prop('disabled', disabled);
    $('#close_avatar_upload_modal').prop('disabled', disabled);
}

function beforeAvatarUpload()
{
    var avatarFormModalMessage = $("#avatarFormModalMessage");
    avatarUploadModalSetControlsDisabled(true);
    avatarFormModalMessage.html('Upload en cours ... <span id="avatarUploadProgressText">0</span>%' +
        '<div class="progress progress-striped active">' +
    '<div class="progress-bar" id="avatarUploadProgressBar" style="width: 0%"></div>' +
    '</div>');
    window.avatarUploadProgressBar = $("#avatarUploadProgressBar");
    window.avatarUploadProgressText = $('#avatarUploadProgressText');
    avatarFormModalMessage.fadeIn('slow');
    return true;
}

function afterUploadAvatar()
{
    $("#avatarFormModal").modal("hide");
    $("#avatarFormModalMessage").html("");
    avatarUploadModalSetControlsDisabled(false);
    showNotification("Succès : ", "Votre image de profil a été modifiée avec succès !", "success");
}


function avatarUplpoaded(data)
{
    var avatarFormModalMessage = $("#avatarFormModalMessage");
    if (data["success"])
    {
        avatarFormModalMessage.fadeOut('slow',function()
        {
            avatarFormModalMessage.html(getSucessDivbegin() +
             'Votre nouvel avatar a bien été enregistré.' +
            getEndDiv());
            avatarFormModalMessage.fadeIn('slow',function(){
                refreshAvatarSection();
                refreshUserBar();
                setTimeout('afterUploadAvatar();', 1000);
            });
        });
    }
    else
    {
        avatarFormModalMessage.fadeOut('slow',function()
        {
            avatarFormModalMessage.html(getErrorDivBegin() +
            data["message"] +
            getEndDiv());
            avatarFormModalMessage.fadeIn('slow');
            avatarUploadModalSetControlsDisabled(false);
        });
    }
}

function avataeUploadProgress(event, position, total, percentComplete )
{
    window.avatarUploadProgressBar.css('width', percentComplete + "%");
    window.avatarUploadProgressText.html(percentComplete);
}

function avatarUploadServerError()
{
    var avatarFormModalMessage = $("#avatarFormModalMessage");
    avatarFormModalMessage.fadeOut('slow',function()
    {
        avatarFormModalMessage.html(getConnectionErrorMessage());
        avatarFormModalMessage.fadeIn('slow');
        avatarUploadModalSetControlsDisabled(false);
    });
}

function prepareModalAvatarForm()
{
    $("#avatarUploadForm").ajaxForm({
        beforeSubmit:beforeAvatarUpload,
        success:avatarUplpoaded,
        clearForm:true,
        uploadProgress:avataeUploadProgress,
        error:avatarUploadServerError
    });
}


function showModalAvatarForm()
{
    if (!window.avatarFormShown) {
        $.get( Routing.generate('quote_cms_user_change_avatar'), function(data) {
            $( "body" ).append(data);
            window.avatarFormShown = true;
            $('#avatarFormModal').modal();
            prepareModalAvatarForm();
        });
    }
    else
        $('#avatarFormModal').modal();
    return false;
}
