Dropzone.autoDiscover = false;
/*var loggedIn = false;
var isTouchScreen = null;
*/

function coffee()
{
  showNotification("Erreur - 418 : ", "Je suis une théière !", "danger");
  return false;
}

var _paq = _paq || [];

function loadStats()
{
  try {
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);

    var u="https://piwik.gamers-life.fr/";
    _paq.push(['setTrackerUrl', u+'p.php']);
    _paq.push(['setSiteId', 3]);

    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'p.js'; s.parentNode.insertBefore(g,s);
  }
  catch (e)
  {
    (function() {
      var img = document.createElement('img');
      img.src = 'https://piwik.gamers-life.fr/p.php?idsite=3';
      document.body.appendChild(img);
    })();
  }
}

function dRInit(isLoggedIn)
{
  window.loggedIn = isLoggedIn;

  // Wee need to know if device run on iOS
  window.isIOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );

  loadStats();
  checkCookieRedirectBeforeChangePage();
  //showCookiesNotification("À des fins statistiques ce site utilise les cookies, acceptez-vous l&#039;utilisation des cookies ?", "Oui", "Non", "En savoir plus");
  if (!thisDeviceToucheScreen())
  {
    $('[data-toggle="tooltip"]').tooltip({
      trigger: "hover"
    });

    $("[data-toggle=popover]").popover({
      html : true,
      content: function() {
        var content = $(this).attr("data-popover-content");
        return $(content).children(".popover-body").html();
      }
    });
  }
  var cn = "BCN";
  if ($.cookie(cn) == null)
  $.cookie(cn, 1, {
    expires : 365,
    secure : true,
    path: "/",
  });
}

function getSucessDivbegin()
{
  return '<div class="alert alert-success"><i class="glyphicon glyphicon-ok"></i> ';
}

function getErrorDivBegin()
{
  return '<div class="alert alert-danger">'+'<i class="glyphicon glyphicon-remove"></i> ';
}

function getEndDiv()
{
  return "</div>";
}

function getConnectionErrorMessage()
{
  return getErrorDivBegin() + 'Connexion au serveur interrompue :('+getEndDiv();
}

function getLoadingCircle(id)
{
  return '<span id="ID_TO_CHANGE" class="glyphicon glyphicon-refresh"></span> '.replace("ID_TO_CHANGE", id);
}

function closeLoginShowReset()
{
  if ($("#loginModal").modal('hide') != null)
  setTimeout('showModalResetForm();', 400);
  return false;
}

function closeLoginShowRegister()
{
  if ($("#loginModal").modal('hide') != null)
  setTimeout('showModalRegisterForm();', 400);
  return false;

}

function closeRegisterShowLogin()
{
  if ($("#registerModal").modal('hide') != null)
  setTimeout('showModalLoginForm();', 400);
  return false;
}

function refreshUserBar()
{
  $.get(Routing.generate('quote_cms_user_navbar'),function(data, status)
  {
    if (status == "success")
    {
      // Update with php result
      $("#UserNavBar").html(data);
    }
  });

  // javascript update
  if (window.loggedIn)
  {
    // forum auto login
    $("a[href^='https://forum.gamers-life.fr/']")
    .each(function()
    {
      this.href = this.href + "session/sso";
    });
  }
}

function clearModalWhenHidden(modal)
{
  modal.on('hidden.bs.modal', function (e) {
    modal.remove();
  });
}

function showNotification(title, message, type, url)
{
  // if url does not exist url = null
  url = typeof url !== 'undefined' ? url : null;

  var icon = "glyphicon ";

  if (type == "success")
  {
    icon += "glyphicon-ok";
  }
  else if (type == "info")
  {
    icon += "glyphicon-info-sign";
  }
  else
  {
    icon += "glyphicon-remove";
  }

  var notifFrom = "top";
  var notifAlign = "right";

  if (!window.isMdDevice)
  {
    notifFrom = "bottom";
    notifAlign = "center";
  }

  if (title != "" && title != null)
  {
    title = "<b>" + title + "</b>";
  }

  $.notify({
    // options
    icon: icon,
    title : title,
    message: message,
    url: url,
    target: "_blank"
  },{
    // settings
    element: "body",
    type: type,
    delay: 5000,
    timer: 1000,
    placement: {
      from: notifFrom,
      align: notifAlign
    },
    animate: {
      exit: 'animated fadeOutUp',
      enter: 'animated fadeInDown'
    }
  });
}

function WhoMadeThis()
{
  console.log("V2hhbnQgdG8ga25vdyB3aG8gbWFkZSB0aGlzID8gZmluZCB3aGF0IHRoZXNlcyBzdHJpbmcgcmVmZmVyIHRvIDogNDY5ZjA2MDgyODgzMGVkODQwNDcyNThjYjUyNWRkM2IsIDA2ZDExMmIwMjI0MWUwYzY4NTYyN2E4Mjk3NjMxMDkxLCBjZWI5OTdhODJiZGVhNzBlMGU3MmM1OWFhODkwMDZjYSwgODQzM2IxMmMxNWZiNTdjZWVmZWY1YThkNWE0N2FhNjUsIDVjNTk3MzZiODRjYmRiMWViMGU0M2E4ZDBmMTI0YTEyLCA4ZDA1ZTcxMTUzZDY5OWYxMDUwNTIxODgwYmZhZDZmYi4NClRoZW4gaWYgeW91IG93biB0aGUgYW53c2VyIHNlbmQgYSBtYWlsIHRvICRUaGVBbnN3ZXIgLiAiQGdhbWVycy1saWZlLnd0ZiI=");
  return true;
}

// Social function
function refreshPostSocialCount(type, subjectId, socialName)
{
  $.get( Routing.generate('quote_cms_core_refresh_social', {'subjectId' : subjectId,
  'socialName' : socialName,
  'type': type}), null);
}

function showTwitterShare(control, type, subjectId)
{
  refreshPostSocialCount(type, subjectId, "twitter");
  if (!window.isIOS)
  {
    window.open(control.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');
    return false;
  }
  else {
    return true;
  }
}

function showFacebookShare(control, type, subjectId)
{
  refreshPostSocialCount(type, subjectId, "facebook");
  if (!window.isIOS)
  {
    window.open(control.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=700');
    return false;
  }
  else
  {
    return true;
  }
}

function showGooglePlusShare(control, type, subjectId)
{
  refreshPostSocialCount(type, subjectId, "google");
  if (!window.isIOS)
  {
    window.open(control.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=450,width=650');
    return false;
  }
  else
  {
    return true;
  }
}

function tryLSCompatibility()
{
  var testStorageID = "QCMS_TEST";
  try {
    localStorage.setItem(testStorageID, 1);
    if (localStorage.getItem(testStorageID) == 1)
    {
      localStorage.removeItem(testStorageID);
      return true;
    }
    else
    {
      return false;
    }
  } catch (e) {
    return false;
  }
}
