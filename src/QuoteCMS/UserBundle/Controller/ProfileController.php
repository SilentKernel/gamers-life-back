<?php

namespace QuoteCMS\UserBundle\Controller;

use QuoteCMS\UserBundle\Form\UserPrefType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\ProfileController as FoSBaseProfileController;


class ProfileController extends FoSBaseProfileController
{
    /**
     * Edit the user
     */
    public function editAction()
    {
        $request = $this->container->get("request");

        $twigParameter["user"] = $this->container->get('security.context')->getToken()->getUser();

        if (!is_object($twigParameter["user"]) || !$twigParameter["user"] instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if(!$twigParameter["user"]->getOauth())
        {
            $form = $this->container->get('fos_user.profile.form');
            $formHandler = $this->container->get('fos_user.profile.form.handler');

            $process = $formHandler->process($twigParameter["user"]);
            if ($process) {
                $this->setFlash('success', 'Votre profil a été mis à jour');

                return new RedirectResponse($this
                    ->container
                    ->get("router")
                    ->generate("fos_user_profile_edit"));
            }

            $twigParameter["formBase"] = $form->createView();

            foreach ($form->getErrors() as $error)
            {
               //var_dump($error->getMessage());
            }
        }

        $userPref = $twigParameter["user"]->getPref();
        $formpref = $this->container->get('form.factory')->create(new UserPrefType(),$userPref);
        // here we will process this form;
        $twigParameter["formUserPref"] = $formpref->createView();

        $twigParameter["section"] = $request->query->get("section", "general");
        // Prevent guys to send shitly think in the url ...
        if ($twigParameter["section"] != "general" && $twigParameter["section"] != "preferences")
        {
          $twigParameter["section"] = "general";
        }


        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:edit.html.twig',
            $twigParameter
        );
    }
}
