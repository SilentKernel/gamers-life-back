<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class PostsSinceOriginController extends Controller
{
    public function showPostsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


            $postsQueryResult = $em->getRepository("QuoteCMSPostBundle:Post")
                ->getPostsSinceOrigin();

            // pagination
            $posts = $this->get('knp_paginator')->paginate($postsQueryResult,
                $request->query->getInt('page', 1));

            return $this->render('QuoteCMSPostBundle:List:ListSinceOrigin.html.twig', array(
                'posts' => $posts
            ));


    }
}
