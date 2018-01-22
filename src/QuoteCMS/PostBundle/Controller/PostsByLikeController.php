<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostsByLikeController extends Controller
{
  public function showPostsAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $postsQueryResult = $em->getRepository("QuoteCMSPostBundle:Post")
    ->getByPlusOne();

    // pagination
    $posts = $this->get('knp_paginator')->paginate($postsQueryResult,
    $request->query->getInt('page', 1));

    return $this->render('QuoteCMSPostBundle:List:ListByLike.html.twig', array(
      'posts' => $posts
    ));


  }
}
