<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;



class MainController extends Controller
{
    public function showSingleAction($gameSlug, $postSlug, Request $request)
    {
        $post = $this->getDoctrine()
            ->getManager()
            ->getRepository("QuoteCMSPostBundle:Post")
            ->findOneBy(array("slug" => $postSlug, 'validated' => true));


        if ($post == null)
            throw $this->createNotFoundException("#GL introuvable");

        $commentData = $this
            ->get("silentkernel_comment.service")
            ->generateCommentPage(1,
                $post->getId(),
                $request,
                $request->get('_route') /* route of this Action */,
                array("postSlug" => $postSlug, "gameSlug" => $gameSlug) /* Param of this Action */);


        return $this->render("QuoteCMSPostBundle:Single:Single.html.twig", array(
            'post' => $post,
            'commentData' => $commentData));
    }
}