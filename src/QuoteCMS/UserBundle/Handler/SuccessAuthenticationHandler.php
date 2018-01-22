<?php

namespace QuoteCMS\UserBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;


class SuccessAuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    const SessionSSOTag = "SSO.Login";
    private $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($request->isXmlHttpRequest())
        {
            return new JsonResponse(array('success' => true));
        }
        else
        {
            $session = $request->getSession();
            // Does it come from the forum ?
            if ($session->has(self::SessionSSOTag))
            {
                $URL = $session->get(self::SessionSSOTag);
                $session->remove(self::SessionSSOTag);
                return new RedirectResponse($URL);
            }

            return new RedirectResponse($this->router->generate('quote_cms_core_homepage'));
        }
    }
}