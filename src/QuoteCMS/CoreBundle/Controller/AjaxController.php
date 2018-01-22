<?php

namespace QuoteCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AjaxController extends Controller
{

  public function refreshShareCountAction($type, $subjectId, $socialName)
  {
    // this will be called in ajax when someone click on the share button
    $shareCountService = $this->container->get("silentkernel_social_api.get_share_count");
    $em = $this->getDoctrine()->getManager();

    if ($type == "q")
    {
      $subject = $em->getRepository("QuoteCMSPostBundle:Post")->findOneById($subjectId);
    }
    else if ($type == "b")
    {
      $subject = $em->getRepository("QuoteCMSBlogBundle:Article")->findOneById($subjectId);
    }

    if ($subject != null)
    {
      if ($type == "q")
      {
        $url = $this->generateUrl('quote_cms_post_view_single', array(
          'postSlug' => $subject->getSlug(),
          'gameSlug' => $subject->getGame()->getSlug()
        ), true);
      }
      else if ($type == "b")
      {
        $url = $this->generateUrl('quote_cms_blog_view_single', array(
          'articleSlug' => $subject->getSlug()
        ), true);
      }

      $shareCount = $subject->getShareCount();

      $changed = false;
      // Get Count From Social Media (0 if fail)
      if ($socialName == "facebook")
      {
        $facebookCount = intval($shareCountService->get_likes($url));
        if ($facebookCount > 0)
        $shareCount->setFacebook($facebookCount + 1);
        else
        $shareCount->setFacebook($shareCount->getFacebook() + 1);
        $changed = true;
      }

      elseif ($socialName == "google")
      {
        $googleCount = intval($shareCountService->get_plusones($url));
        if ($googleCount > 0)
        $shareCount->setGoogle($googleCount + 1);
        else
        $shareCount->setGoogle($shareCount->getGoogle() + 1);
        $changed = true;
      }

      elseif ($socialName == "twitter")
      {
        $twitterCount = intval($shareCountService->get_tweets($url));
        if ($twitterCount > 0)
        $shareCount->setTwitter($twitterCount + 1);
        else
        $shareCount->setTwitter($shareCount->getTwitter() + 1);
        $changed = true;
      }

      if ($changed)
      {
        $em->persist($shareCount);
        $em->flush();
      }
    }
    return new Response("");
  }

  public function cookiesMoreInfoAjaxAction()
  {
    return $this->render('::CookiesMoreInfo.html.twig');
  }
}
