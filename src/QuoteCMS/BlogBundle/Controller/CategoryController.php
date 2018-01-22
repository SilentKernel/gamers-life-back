<?php

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use SymfonyComponentHttpFoundationRequest;

class CategoryController extends Controller
{
  public function AllCategoryAction()
  {
    $categories = $this->getDoctrine()
    ->getManager()
    ->getRepository("QuoteCMSBlogBundle:Category")
    ->findBy(array(), array("creationDate" => "DESC"));

    return $this->render("QuoteCMSBlogBundle:Category:All.html.twig", array(
      "categories" => $categories
    ));
  }

  public function oneCategory($categorySlug)
  {
    // go to repos to create the request !
    $articles = $paginator = $this->get("knp_paginator")->paginate(
    $this->getDoctrine()
    ->getManager()
    ->getRepository("QuoteCMSBlogBundle:Article")
    ->getArtcleQueryByCatSlug($categorySlug)),
    $request->query->getInt("page", 1),
    5);

    return $this->render("QuoteCMSBlogBundle:Category:List.html.twig", array(
      "articles" => $articles
    ));
  }
}

?>
