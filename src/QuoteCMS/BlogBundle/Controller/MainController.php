<?php

namespace QuoteCMS\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
  public function homeAction(Request $request)
  {
    // Pagination, 5 per pages.
    $articles = $paginator = $this->get("knp_paginator")->paginate(
    $this->getDoctrine()
    ->getManager()
    ->getRepository("QuoteCMSBlogBundle:Article")
    ->findBy(array(), array("creationDate" => "DESC")),
    $request->query->getInt("page", 1),
    5);

    return $this->render("QuoteCMSBlogBundle::home.html.twig",
    array("articles" => $articles));
  }

  public function showSingleAction($articleSlug, Request $request)
  {
    $article = $this
    ->getDoctrine()
    ->getManager()
    ->getRepository("QuoteCMSBlogBundle:Article")
    ->findOneBySlug($articleSlug);

    if ($article == null)
    {
      throw $this->createNotFoundException("Article introuvable");
    }
    else
    {
      // Call to SilentkernelCommentBundle
      $commentData = $this
      ->get("silentkernel_comment.service")
      ->generateCommentPage(2 /* Context ID, Blog = 2 */,
      $article->getId(),
      $request,
      $request->get('_route') /* route of this Action */,
    array("articleSlug" => $articleSlug) /* Param of this Action */);

    return $this->render("QuoteCMSBlogBundle:Single:Single.html.twig", array(
      "article" => $article,
      "commentData" => $commentData
    ));
  }
}
}
