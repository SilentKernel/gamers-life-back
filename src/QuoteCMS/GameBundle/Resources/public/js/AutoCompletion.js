
function initGamePostAE()
{
    var valName = "v";
    var QueryName = "THE_QUERY_K";

    gameAutoCompletion = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace(valName),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: Routing.generate('quote_cms_game_g_auto_complete'),
        remote: {
            url: Routing.generate('silentkernel_se_auto_complete', {'keywords' : QueryName}),
            wildcard: 'THE_QUERY_K'
        }
    });

    gameAutoCompletion.initialize();

    var gameList = $('#quotecms_postbundle_post_game');
    var temGetNameInput = $('#quotecms_postbundle_post_tempGameName');
    temGetNameInput.typeahead(null, {
        display: valName,
        source: gameAutoCompletion
    });

    temGetNameInput.on('input', function() {
        gameList.prop('disabled', (temGetNameInput.val() != ""));
    });

    var addGLForm = $("#addPostForm");
    addGLForm.on('submit', function() {
        gameList.prop('disabled', false);
    });
}