function showAdviceModal()
{
  var adviceModal = $("#post_advice_modal");
  if (typeof adviceModal.html() == "undefined")
  {
    var adviceText = "<div class=\"modal fade\" id = \"post_advice_modal\">";
    adviceText += "<div class=\"modal-dialog modal-lg\">";
    adviceText += "<div class=\"modal-content\">";
    adviceText += "<div class=\"modal-header hidden-xs\">";
    adviceText += "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×<\/button>";
    adviceText += "<h4 class=\"modal-title\">Conseils<\/h4>";
    adviceText += "<\/div>";
    adviceText += "<div class=\"modal-body\">";
    adviceText += "<p>Envie de devenir célèbre en postant la GL la plus drôle de tous les temps ? Suivez ces quelques conseils.<\/p>";
    adviceText += "<ul>";
    adviceText += "<li>N’abusez pas sur le langage g33k. Votre histoire doit rester compréhensible.<\/li>";
    adviceText += "<li>Essayer d’envoyer vos histoires avec le moins de fautes d’orthographes possibles.<\/li>";
    adviceText += "<li>Nous privilégierons les histoires avec des vidéos où des images.<\/li>";
    adviceText += "<li>Pensez à anonymiser votre image et\/ou vidéo. Peut être n’avez-vous pas envie que votre pseudo s’affiche par exemple ?<\/li>";
    adviceText += "<li>Il est interdit de poster des images\/vidéos trouvées sur internet. Les illustrations doivent être de votre création. (Oui, chez nous, Impr écran, c’est de l’art.)<\/li>";
    adviceText += "<\/ul>";
    adviceText += "<p><b>Vous acceptez en soumettant vos histoires de nous les confier. Elles pourront ainsi être modifiées, publiées, sur Gamer’s Life ou autre site.<\/b><\/p>                ";
    adviceText += "<\/div>";
    adviceText += "<div class=\"modal-footer\">";
    adviceText += "<button type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Fermer<\/button>";
    adviceText += "<\/div>";
    adviceText += "<\/div>";
    adviceText += "<\/div>";
    adviceText += "<\/div>";
    $("body").append(adviceText);
    adviceModal = $("#post_advice_modal");
  }
  adviceModal.modal();
  return false;
}
