<?php

namespace Silentkernel\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Silentkernel\CommentBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxModerationController extends Controller
{
  public function moderatorDeleteCommentAction(Comment $comment)
  {
    $securityContext = $this->get("security.context");
    if ($securityContext->isGranted("ROLE_MODERATOR"))
    {
      if ($comment->getDeletedByModeration() == false)
      {
        $comment->setDeletedByModeration(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush($comment);
        return new JsonResponse(array("success" => true, "message" => "Commentaire supprimé"));
      }
      else
      {
        return new JsonResponse(array("success" => false, "message" => "Commentaire déjà supprimé"));
      }
    }
    else
    {
      // is not moderator !
      return new JsonResponse(array('success' =>  false, "message" => "Erreur 418 - Je suis une théière, je ne comprends pas !"));
    }
  }
}
