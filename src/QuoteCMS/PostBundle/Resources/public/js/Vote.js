function QuoteVoteStorageManager(value)
{
  var stringStorage = "votePost";

  if (value == "get")
  {
    var localSvalue = localStorage.getItem(stringStorage);
    if (localSvalue == null)
    {
      return "";
    }
    else
    {
      return localSvalue;
    }
  }
  else
  {
    localStorage.setItem(stringStorage, value)
  }
}

function askServerVoteQuote(postID, Value, localStorageString)
{
  var votePostRequest = $.post(Routing.generate("quote_cms_ajax_post_vote",
  {"post" : postID, "value" :  Value}),
  {lstorage: localStorageString });

  votePostRequest.done(function(data)
  {
    if (data.success)
    {
      var type = "success";
    }
    else
    {
      var type = "danger";
    }

    if (typeof data.localStorageMessage != "undefined")
    {
      QuoteVoteStorageManager(data.localStorageMessage);
    }

    showNotification(data.title, data.message, type);
  });

  votePostRequest.fail(function(e){
    showNotification("Erreur : ", "Connexion au serveur impossible, vote annulé.", "danger");
  });
}

function quoteVote(postID, Value)
{
  if (window.loggedIn)
  {
    askServerVoteQuote(postID, Value, "");
  }
  else
  {
    // we are going to try if we can write in the local storage
    if (tryLSCompatibility())
    {
      var localStorage = QuoteVoteStorageManager("get");
      if (localStorage == "")
      {
        askServerVoteQuote(postID, Value, localStorage);
      }
      else
      {
        var localJSON = JSON.parse(Base64.decode(localStorage));
        if (localJSON.indexOf(postID) > -1)
        {
          showNotification("(#GL : "+ postID +") : ", "Vous avez déjà voté pour cette #GL.", "danger");
        }
        else
        {
          askServerVoteQuote(postID, Value, localStorage);
        }
      }
    }
    else
    {
      showNotification("", 'Votre navigateur ne prend pas en charge le vote hors connexion, <a class="comment-notif-link" href="#" onclick="return showModalLoginForm();">connectez vous</a> pour voter pour cette #GL', "danger");
    }
  }
  return false;
}
