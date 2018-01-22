<?php

namespace QuoteCMS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class MainController extends Controller
{
    const cookieRedirect = "OAuth_r";

    public function homeAction(Request $request)
    {
        $securityContext = $this->get("security.context");

        // TODO : this should be a part of UserBundle, will move it later
        if ($securityContext->isGranted("IS_AUTHENTICATED_REMEMBERED"))
        {
            // Only for OAuth User !
            if ($securityContext->getToken()->getUser()->getOAuth())
            {
                // Here check if we just logged in and need to get redirected !
                $cookies = $request->cookies;

                if ($cookies->has(self::cookieRedirect))
                {
                    $redirectionURL = $cookies->get(self::cookieRedirect);

                    // Check if we redirect on our doimain
                    $RedirectionHost = parse_url($redirectionURL, PHP_URL_HOST);
                    $protocol = parse_url($redirectionURL, PHP_URL_SCHEME);

                    if (($RedirectionHost == $this->container->getParameter('site_host')) && ($protocol == "https")) // prevent http redirection
                    {
                        $session = $request->getSession();
                        if ($session->get(self::cookieRedirect) != $redirectionURL)
                        {
                          $session->set(self::cookieRedirect, $redirectionURL);
                          $redirectResp = new RedirectResponse($redirectionURL);
                          // Not infinite loop :D
                          $redirectResp->headers->clearCookie(self::cookieRedirect);
                          return $redirectResp;
                        }
                    }
                }
            }
        }

        $em = $this->getDoctrine()->getManager();

        // Here we will put the filter if user is logged in
        $postsQueryResult = $em->getRepository("QuoteCMSPostBundle:Post")
            ->getAll();

        // pagination
        $posts = $this->get('knp_paginator')->paginate($postsQueryResult,
            $request->query->getInt('page', 1));

        return $this->render('QuoteCMSCoreBundle::home.html.twig', array(
            'posts' => $posts
        ));
    }
}
