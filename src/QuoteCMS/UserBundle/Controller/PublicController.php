<?php

namespace QuoteCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PublicController extends Controller
{
    /**
     * View Public Page
     */
    public function showUserAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("QuoteCMSUserBundle:User")
            ->findOneBySlug($slug);

        if ($user === null) {
            throw $this->createNotFoundException("L'utilisateur n'existe pas.");
        }

        return $this->render('QuoteCMSUserBundle:Public:view.html.twig', array(
            'user'           => $user,
        ));
    }
}
