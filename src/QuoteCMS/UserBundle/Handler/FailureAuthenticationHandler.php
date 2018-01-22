<?php

namespace QuoteCMS\UserBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\JsonResponse;


class FailureAuthenticationHandler implements AuthenticationFailureHandlerInterface
{

    protected $router;
    protected $service_container;

    public function __construct(RouterInterface $router, $service_container)
    {
        $this->router = $router;
        $this->service_container = $service_container;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
        if ($request->isXmlHttpRequest())
		{
		   return new JsonResponse (array(
		        'success' => false,
		        'message' => $this->service_container->get('translator')->trans($exception->getMessageKey(), $exception->getMessageData(), 'security')/*,
                'csrf' =>  $this->service_container->get('form.csrf_provider')->generateCsrfToken("authenticate")*/
		    ));
		}
		else
		{
			$error = $this->service_container->get('translator')->trans($exception->getMessageKey(), $exception->getMessageData(), 'security');
			$request->getSession()->getFlashBag()->add('error', $error);
			return new RedirectResponse($this->router->generate('fos_user_security_login'));
		}
	}
}