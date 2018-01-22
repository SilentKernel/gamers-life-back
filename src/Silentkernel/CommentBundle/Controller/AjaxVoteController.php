<?php
/**
 * Created by PhpStorm.
 * User: Silent
 * Date: 11/08/2015
 * Time: 07:23
 */

namespace Silentkernel\CommentBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silentkernel\CommentBundle\Entity\Comment;

class AjaxVoteController extends Controller
{

    public function plusOneAction(Comment $comment)
    {
        $result = array(
            "success" => false,
            "message" => "Vous n'êtes pas connecté."
        );

        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $user = $securityContext->getToken()->getUser();

            if ($user == $comment->getUser())
            {
                $result["message"] = "Vous ne pouvez pas voter pour votre propre commentaire.";
            }
            elseif ($comment->getUsersVote()->contains($user))
            {
                $result["message"] = "Vous avez déjà voté pour ce commentaire.";
            }
            else
            {
                $em = $this->getDoctrine()->getManager();
                $comment->addUsersVote($user);
                $comment->setPlusOne($comment->getPlusOne()+1);
                $em->persist($comment);
                $em->flush();

                $result["success"] = true;
                $result["message"] = "Votre vote a bien été enregistré, merci.";
            }
        }
        return new JsonResponse($result);
    }

}
