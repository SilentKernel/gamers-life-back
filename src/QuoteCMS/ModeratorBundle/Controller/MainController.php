<?php

namespace QuoteCMS\ModeratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository("QuoteCMSPostBundle:Post")
            ->getNoValidatedPosts();

        $comments = $em->getRepository("SilentkernelCommentBundle:Comment")
            ->getNoValidateComments();

        $reports = $em->getRepository('SilentkernelCommentBundle:Comment')
            ->getReportComments();

        return $this->render('QuoteCMSModeratorBundle::Index.html.twig',array(
            'posts' => $posts,
            'comments' => $comments,
            'reports' => $reports
        ));
    }

    public function mobileGeneratePicsAction()
    {
      $em = $this->getDoctrine()->getManager();
      $avatars = $em->getRepository("QuoteCMSUserBundle:Avatar")->findAll();
      $screenshots = $em->getRepository("QuoteCMSPostBundle:PostPicture")->findAll();

      return $this->render("QuoteCMSModeratorBundle::generateMobilePics.html.twig",
      array("avatars" => $avatars, "screenshots" => $screenshots));
    }
}
