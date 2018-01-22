<?php

namespace QuoteCMS\DeviceAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BlogController extends Controller
{

  const resultArray = "articles";
  const resultPerPage = 20;

  private function getArticlesListJson($articles)
  {
    $resp = array();

    $i = 0;
    foreach ($articles->getItems() as $article)
    {
      $resp[self::resultArray][$i]["id"] = $article->getId();
      $resp[self::resultArray][$i]["author"] = $article->getUser()->getNickname();
      $resp[self::resultArray][$i]["title"] = $article->getTitle();
      $resp[self::resultArray][$i]["creationDate"] = $article->getCreationDate()->format("d/m/Y");
      $resp[self::resultArray][$i]["content"] = str_replace("\n", "", $this->render(
        "QuoteCMSBlogBundle:Single:Parser.html.twig",
        array("article" => $article,
          "truncate" => true))
        ->getContent());

      $i++;
    }

    $resp["maxItems"] = $articles->getTotalItemCount();

    return $resp;
  }

  public function getArticlesListAction($page)
  {
    // if send shitly page
    $page = intval($page);
    if ($page < 1)
      return new JsonResponse(array());

    $articles = $this->get("knp_paginator")->paginate(
    $this->getDoctrine()
    ->getManager()
    ->getRepository("QuoteCMSBlogBundle:Article")
    ->findBy(array(), array("creationDate" => "DESC")),
    $page,
    self::resultPerPage);

    return new JsonResponse($this->getArticlesListJson($articles));
  }

}
