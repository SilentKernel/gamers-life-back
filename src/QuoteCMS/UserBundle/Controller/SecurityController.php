<?php


namespace QuoteCMS\UserBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Controller\SecurityController as FoSBaseSecurityController;

class SecurityController extends FoSBaseSecurityController
{
    public function loginAction()
    {
        $request = $this->container->get('request');
        //If basic authentication FoS Handle it !
        if(!$request->isXmlHttpRequest()){
            return parent::loginAction();
        }
        // else we handle it
        else
        {
            $session = $request->getSession();
            $twigParameters["last_username"] =  (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
            $twigParameters["csrf_token"] = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
            return $this->renderAjaxLogin($twigParameters);
        }
    }

    // This is the same as renderLogin but here the twig template is a bootstrap modal
    protected function renderAjaxLogin(array $data)
    {
        $template = sprintf('QuoteCMSUserBundle:Security:loginModal.html.%s', $this->container->getParameter('fos_user.template.engine'));

        return $this->container->get('templating')->renderResponse($template, $data);
    }
}
