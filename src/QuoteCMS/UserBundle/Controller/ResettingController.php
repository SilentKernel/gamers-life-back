<?php


namespace QuoteCMS\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ResettingController as FoSBaseResettingController;
use Symfony\Component\HttpFoundation\JsonResponse;



class ResettingController extends FoSBaseResettingController
{
    public function requestAction()
    {
        $request = $this->container->get('request');
        if (!$request->isXmlHttpRequest()){
            return parent::requestAction();
        }
        else {
            return $this->container->get('templating')->renderResponse(
                'QuoteCMSUserBundle:Resetting:requestModal.html.twig');
        }
    }

    public function sendEmailAction()
    {
        $request = $this->container->get('request');
        if (!$request->isXmlHttpRequest()){
            return parent::sendEmailAction();
        }
        else
        {
            // There twig WILL NOT wash this so we do it manually
            // If you remove htmlspecialchars(); there will have xss injection posibility ...
            // https://www.youtube.com/watch?v=Rj08pmfBFHo
            $username = htmlspecialchars($request->request->get('username'));
            $user = $this->container->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);
            $result["success"] = true;

            if (null === $user) {
                $result["success"] = false;
                $result["message"] = $username . " n'est pas un nom d'utilisateur ou une adresse mail valide.";
                return new JsonResponse($result);
            }

            if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
                $result["success"] = false;
                $result["message"] = "Une demande de changement de mot de passe à déjà été demandé récemment pour ce compte.";
                return new JsonResponse($result);
            }

            if (null === $user->getConfirmationToken()) {
                $tokenGenerator = $this->container->get('fos_user.util.token_generator');
                $user->setConfirmationToken($tokenGenerator->generateToken());
            }

            // Sending the mail
            $this->container->get('fos_user.mailer')->sendResettingEmailMessage($user);
            // Set NOW the last time this guy asked for an email
            $user->setPasswordRequestedAt(new \DateTime());
            // We save last time this user asked to change email
            $this->container->get('fos_user.user_manager')->updateUser($user);

            // We do not show complete email (if someone want to know the email of an user ????)
            $result["message"] = "Un email a été envoyé à l'adresse " .$this->getObfuscatedEmail($user);

            return new JsonResponse($result);
        }
     }
}
