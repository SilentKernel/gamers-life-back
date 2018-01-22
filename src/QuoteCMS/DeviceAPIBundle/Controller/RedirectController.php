<?php

namespace QuoteCMS\DeviceAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RedirectController extends Controller
{
  public function redirectBaseAction()
  {
    return $this->redirect($this->get("router")->generate("quote_cms_core_homepage"));
  }

/*
  public function redirectUrlAction($url)
  {
    return $this->redirect("https://gamers-life.fr/". $url);
  }
*/
}
