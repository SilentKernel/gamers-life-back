<?php

namespace QuoteCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Cviebrock\DiscoursePHP\SSOHelper;

class SSOController extends Controller
{
    // Same private key on Discourse !
    const privateKey = "mtEisLFVPz6+XP71p8HM85/0SBuGsWVbEqsUQEJ2F4nEb7iSliUyXEFcxp/r/+COE0lkEOnE+bMhzzMKe1TTLg==";
    const avatarUrl = "https://gamers-life.fr/media/";
    const forumLoginUrl = "https://forum.gamers-life.fr/session/sso_login?";
    const SessionSSOTag = "SSO.Login";

    public function SSOLoginAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $payload  = $request->query->get('sso', "");
            $signature  = $request->query->get('sig', "");
            $sso = new SSOHelper();
            $sso->setSecret(self::privateKey);

            if ( ($sso->validatePayload($payload,$signature)))
            {
                // The user is currently loged in !
                $nonce = $sso->getNonce($payload);
                $user = $securityContext->getToken()->getUser();
                $uniqueId = $user->getSSOId();
                $email = $user->getEmail();

                $param = array();
                $param["username"] = str_replace(" ", "_", $user->getNickName());
                $param["require_activation"] = "true";
                //$param["suppress_welcome_message"] = true;

                $avatarEnt = $user->getAvatar();
                if ($avatarEnt != null)
                    $param["avatar_url"] = self::avatarUrl . $avatarEnt->getFileName();



                // return it to discourse.
                $url = self::forumLoginUrl . $sso->getSignInString($nonce, $uniqueId, $email, $param);

                return $this->redirect($url);
            }
        }
        else
        {
            $request->getSession()->set(self::SessionSSOTag, $request->getUri());
            return $this->redirect($this->get("router")->generate("fos_user_security_login"));
        }

        // If we are here someone try to fuck the system :(
        throw $this->createNotFoundException("Cette page n'est pas accessible directement");
    }
}
