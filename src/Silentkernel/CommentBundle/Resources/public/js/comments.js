/**
* Created by Silentkernel on 01/08/2015.
*/


function deleteComment(comment, isModerator)
{
  if (!window.loggedIn)
  {
    showNotification("Erreur : ", '<a href="#" onclick="return showModalLoginForm();">Identifiez-vous</a> pour supprimer un commentaire.', "danger");
  }
  else
  {
    if (isModerator)
    {
      var route = Routing.generate('silentkernel_comment_delete_by_moderator' , {'comment': comment });
    }
    else
    {
      var route = Routing.generate('silentkernel_comment_delete_by_user' , {'comment': comment });
    }
    $.get(route , function(data){
      if (data.success)
      {
        showNotification("", data.message, "success");
        $("#comment-text-" + comment).html("<b>Commentaire supprimé.</b>");
      }
      else
      {
        showNotification("", data.message, "danger");
      }
    });
  }
  return false;
}

function reportComment(commentId)
{
  if (window.loggedIn)
  {
    $.get(Routing.generate("silentkernel_comment_report", { "comment": commentId }),
    function(data)
    {
      if (data.success)
      {
        showNotification("", "Votre signalement a été enregistré.", "success");
      }
      else
      {
        showNotification("", data.message, "danger");
      }
    });
  }
  else
  {
    showNotification("", '<a class="comment-notif-link " href="#" onclick="return showModalLoginForm();">Connectez vous</a> ou <a class="comment-notif-link" href="#" onclick="return showModalRegisterForm();">inscrivez vous</a> pour signaler ce commentaire.', "danger");
  }
  return false;
}

function refreshCommentDiv()
{
  if (typeof commentData != "undefined")
  {
    $.get(Routing.generate("silentkernel_comment_refresh_general_div",
    {
      context: commentData.context,
      contextId: commentData.contextId,
      page: commentData.page,
      routeId: commentData.routeId,
      routeParam: commentData.routeParam,
      routeSignature: commentData.routeSignature
    }),
    function(data)
    {
      $("#silentkernel_comment").html(data);
    });
  }
}

function showAddCommentForm(context, contextId, parentComment)
{
  if (!window.loggedIn)
  {
    showNotification("Erreur : ", '<a href="#" onclick="return showModalLoginForm();">Identifiez-vous</a> pour commenter.', "danger");
  }
  else
  {
    $.get(Routing.generate("silentkernel_comment_add",
    {
      context: context,
      contextId: contextId,
      commentParent: parentComment
    }),
    function(data)
    {
      closeCommentForm();

      if (parentComment == -1)
      {
        $( "#comment-panel-top" ).append(data);
      }
      else if (parentComment == -2)
      {
        $( "#comment-panel-bottom" ).append(data);
      }
      else
      {
        $( "#comment-" + parentComment).append(data);
      }

      preareAddCommentForm();
    });
  }
  return false;
}

function closeCommentForm()
{
  var addCommentForm = $("#addCommentForm");

  if (typeof addCommentForm.html() != 'undefined')
  {
    addCommentForm.remove();
  }
  return false;
}

function commentAddFormSent(data)
{
  var notifType = "danger";
  var title = "Erreur :";

  if (data.Status != "ERROR")
  {
    closeCommentForm();

    $("#comment-list").append(data.commentDiv);

    if (data.Status == "OK")
    {
      notifType = "success";
      title = "Succès :";
    }
    else
    {
      notifType = "info";
      title = "Modération :";
    }
  }

  showNotification(title, data.Message, notifType);
}

function errorConnectionAddFormComment()
{
  showNotification("Erreur :", "Commentaire impossible à envoyer, le serveur ne répond pas.", "danger");
}

function markdownComment()
{
  // Markdown
  $("#silentkernel_commentbundle_comment_message").markdown({
    autofocus:false,
    savable:false,
    language: "fr",
    fullscreen: false,
    resize: "vertical",
    hiddenButtons: ['cmdPreview', "cmdImage", "cmdQuote", "cmdCode"],
    disabledButtons: ['cmdPreview', "cmdImage", "cmdQuote", "cmdCode"]
  });
}

function preareAddCommentForm()
{
  $("#form_add_comment_modal").ajaxForm({
    success:commentAddFormSent,
    error:errorConnectionAddFormComment
  });
  markdownComment();
}
