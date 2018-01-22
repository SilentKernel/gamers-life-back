<?php

namespace QuoteCMS\FaqBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function faqAction()
    {
        return $this->render('QuoteCMSFaqBundle::faq.html.twig');
    }

    public function mentionsAction()
    {
        return $this->render('QuoteCMSFaqBundle::mentions.html.twig');
    }

    public function regulationAction()
    {
        return $this->render('QuoteCMSFaqBundle::reglement.html.twig');
    }
}
