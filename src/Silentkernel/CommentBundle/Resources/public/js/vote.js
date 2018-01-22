/**
 * Created by Silent on 11/08/2015.
 */

function commentVote(commentId)
{
    if (window.loggedIn)
    {
        $.get(Routing.generate("silentkernel_comment_vote",{
                comment: commentId
            })
            ,function(data){
                if (data.success)
                {
                    showNotification("", data.message, "success");
                    var CommentCountSpan = $("#comment-plus-one-" + commentId);
                    var CurrentComCount = parseInt(CommentCountSpan.html());
                    CurrentComCount++;
                    CommentCountSpan.html(CurrentComCount);
                }
                else
                {
                    showNotification("", data.message, "danger");
                }
            });
    }
    else
    {
        showNotification("", '<a class="comment-notif-link " href="#" onclick="return showModalLoginForm();">Connectez vous</a> ou <a class="comment-notif-link" href="#" onclick="return showModalRegisterForm();">inscrivez vous</a> pour voter sur les commentaires.', "danger");
    }

    return false;
}
