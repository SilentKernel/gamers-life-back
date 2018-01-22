<?php

namespace QuoteCMS\PostBundle\Service;

class RandomTools
{
  private $em;

  public function __construct($doctrine)
  {
      $this->em = $doctrine->getManager();
  }

  public function getRandomPost($numberOfPost)
  {
    //on récupère tous les id de posts valide
    $ValidateId = $this->em->getRepository('QuoteCMSPostBundle:Post')
        ->getIdValidated();
    // on en fait un tableau unidimentionel
    $ids = array_map('current',$ValidateId);
    // on fou le bordel dans l'ordre
    shuffle($ids);
    // on récupère que les X première ID de notre salade
    $ids = array_slice($ids,0,$numberOfPost-1);
    // on va chercher les entités liées aux ID précédèntes
    $posts = $this->em->getRepository('QuoteCMSPostBundle:Post')
        ->findBy(array('id' => $ids));
    // On remet un coups de shaker car SQL ne sait que renvoyer des choses ordonées
    shuffle($posts);

    return $posts;
  }

}
