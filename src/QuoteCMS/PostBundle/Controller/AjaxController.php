<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use QuoteCMS\PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Response;


class AjaxController extends Controller
{
    const voteOk = "Vote enregistré, merci.";
    const voteAlreadyVoted = "Vous avez déjà voter pour cette #GL.";

    public function showVideoAction(Post $post)
    {
        return $this->render("QuoteCMSPostBundle:Video:modal.html.twig",array("post" => $post));
    }

    public function showPictureAction($postSlug, $imgNumber)
    {
        $imgNumber = intval($imgNumber);
        if ($imgNumber == 0)
            $imgNumber = 1;

        $post = $this->getDoctrine()
            ->getManager()
            ->getRepository("QuoteCMSPostBundle:Post")
            ->findOneBy(array("slug" => $postSlug, 'validated' => true));

        if ($post == null)
            throw $this->createNotFoundException("#GL introuvable");

        return $this->render("QuoteCMSPostBundle:Picture:PictureModal.html.twig", array(
            'post' => $post,
            'imgNumber' => $imgNumber));
    }

    public function postVoteAction(Post $post, $value, Request $request)
    {
        $value = intval($value);
        $voteTools = $this->get("quote_cms_post.vote_tools");
        $resultTitle = $post->getTitle() . " (#GL : " . $post->getId() . ") : ";

        // if nav send shit, ignore it !
        if ($voteTools->checkValue($value) && ($voteTools->checkBrowser($request->cookies)))
        {
            $securityContext = $this->get('security.context');
            // By Database
            if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            {
                $user = $securityContext->getToken()->getUser();
                if (!$user->getVotedPosts()->contains($post))
                {
                    $voteTools->voteWithUser($post, $value, $user);
                    return new JsonResponse(array(
                        "success" => true,
                        "title" => $resultTitle,
                        "message" => self::voteOk
                    ));
                }
                else
                {
                    return new JsonResponse(array(
                        "success" => false,
                        "title" => $resultTitle,
                        "message" => self::voteAlreadyVoted
                    ));
                }
            }
            // By localStorage
            else
            {
                $voteTools->generateLocalStorageArray($request);
                if ($voteTools->checkLocalStorageCanVote($post))
                {
                    return new JsonResponse(array(
                        "success" => true,
                        "localStorageMessage" => $voteTools->voteWithLocalStorage($post, $value),
                        "title" => $resultTitle,
                        "message" => self::voteOk
                    ));
                }
                else
                {
                    return new JsonResponse(array(
                        "success" => false,
                        "title" => $resultTitle,
                        "message" => self::voteAlreadyVoted
                    ));
                }
            }
        }

        return new JsonResponse(array(
            "success" => false,
            "message" => "Votre navigateur ne prend pas en charge les votes, cookies désactivés."
        ));
    }
}
