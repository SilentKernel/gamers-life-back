<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class PostsByGameController extends Controller
{
  public function showPostsAction(Request $request,$gameSlug = null)
  {
    $em = $this->getDoctrine()->getManager();

    $game = $em->getRepository("QuoteCMSGameBundle:Game")
    ->findOneBySlug($gameSlug);
    if (!$game)
    {
      throw $this->createNotFoundException('Ce jeu n\'existe pas');
    }

    $postsQueryResult = $em->getRepository("QuoteCMSPostBundle:Post")
    ->getByGame($gameSlug);

    // pagination
    $posts = $this->get('knp_paginator')->paginate($postsQueryResult,
    $request->query->getInt('page', 1));

    return $this->render('QuoteCMSPostBundle:List:ListByGame.html.twig', array(
      'posts' => $posts,
      'game' => $game
    ));
  }
}
