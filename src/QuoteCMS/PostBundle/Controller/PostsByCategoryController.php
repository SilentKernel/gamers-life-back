<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class PostsByCategoryController extends Controller
{
    public function showPostsAction(Request $request,$categorySlug = null)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository("QuoteCMSGameBundle:Category")
            ->findOneBySlug($categorySlug);
        if (!$category)
            {
                throw $this->createNotFoundException('Cette catégorie n\'existe pas');
            }

        $postsQueryResult = $em->getRepository("QuoteCMSPostBundle:Post")
            ->getByCategory($categorySlug);

        // pagination
        $posts = $this->get('knp_paginator')->paginate($postsQueryResult,
            $request->query->getInt('page', 1));

        return $this->render('QuoteCMSPostBundle:List:ListByCategory.html.twig', array(
            'posts' => $posts,
            'category' => $category
        ));


    }
}
