<?php

namespace QuoteCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\RememberMe\TokenBasedRememberMeServices;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;

class OAuthController extends Controller
{
    public function rememberOAuthAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $result["success"] = false;

        if ($user->getOauth())
        {
            // here is a hack cause symfony is not made to make it working like this
            $rememberMeService = new TokenBasedRememberMeServices(array($this->
            container->get('fos_user.user_provider.username')),
                $this->container->getParameter("secret"),
                'main', array(
                    'path' => '/',
                    'name' => $this->container->getParameter("remember_me_cookie"),
                    'domain' => null,
                    'secure' => true,
                    'httponly' => true,
                    'lifetime' => 31536000,
                    'always_remember_me' => true,
                    'remember_me_parameter' => '_remember_me')
            );

            $result["success"] = true;
            $response = new JsonResponse($result);
            $rememberMeService->loginSuccess($request, $response, $this->container->get('security.context')->getToken());

            return $response;
        }

        return new JsonResponse($result);
    }
}
