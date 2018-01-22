function prepareDropZone()
{
    $("#postImageUpload").dropzone({
        // Settings
        paramName: "quotecms_postbundle_postpicture[file]",
        maxFilesize: 5,
        acceptedFiles: "image/*",
        maxFiles: 10,
        success: function(file, response)
        {
            if(response.success)
            {
                return file.previewElement.classList.add("dz-success");
            }
            else
            {
                var node, _i, _len, _ref, _results;
                var message = response.message;
                file.previewElement.classList.add("dz-error");
                _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                _results = [];
                for (_i = 0, _len = _ref.length; _i < _len; _i++)
                {
                    node = _ref[_i];
                    _results.push(node.textContent = message);
                }
                return _results;
            }
        },

        // Traduction
        dictDefaultMessage:  '<h3>Déposez vos fichiers ici</h3> <br /> Vous pouvez également cliquer ici pour sélectionner les fichiers à envoyer.',
        dictFallbackMessage: 'Votre navigateur ne supporte pas le "drag and drop".',
        dictFallbackText: "Utilisez le formulaire suivant pour envoyer vos fichiers avec l'ancienne méthode.",
        dictFileTooBig: "Ce fichier est trop gros ({{filesize}}MiB). La taille max est de {{maxFilesize}}MiB.",
        dictInvalidFileType: "Seules les images sont autorisées.",
        dictResponseError: "Le serveur a renvoyé une erreur {{statusCode}}.",
        dictCancelUpload: "Annuler l'envoi.",
        dictCancelUploadConfirmation: "Êtes-vous sur de vouloir annuler cet envoi ?",
        dictRemoveFile: "Supprimer ce fichier.",
        dictMaxFilesExceeded: "Vous ne pouvez pas envoyer plus de fichiers (max 10)."
    });
}

function showModalUploadForm(postFormUID)
{
    if (!window.postUploadFormShown) {
        $.get( Routing.generate('quote_cms_core_post_new_picture', {'postFormId' : postFormUID }), function(data) {
            $( "body" ).append(data);
            window.postUploadFormShown = true;
            $('#postUploadModal').modal();
            prepareDropZone();
        });
    }
    else
        $('#postUploadModal').modal();

    return false;
}
