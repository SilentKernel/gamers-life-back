<?php


namespace QuoteCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class NavbarController extends Controller
{
    public function showUserBarAction()
    {
        $user= $this->get('security.context')->getToken()->getUser();
        return $this->render("QuoteCMSUserBundle:Navbar:UserMenu.html.twig",
            array ('user' => $user));
    }

}