<?php

namespace QuoteCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use QuoteCMS\UserBundle\Form\UserPrefType;

class PrefValidatorController extends Controller
{

  public function updatePrefAction(Request $request)
  {
    $SContext = $this->get("security.context");
    if ($SContext->isGranted("IS_AUTHENTICATED_REMEMBERED"))
    {
      $pref = $SContext->getToken()->getUser()->getPref();
      if ($request->isMethod("POST"))
      {
        $flashBag = $request->getSession()->getFlashBag();
        $form = $this->get('form.factory')->create(new UserPrefType(), $pref);

        if ($form->handleRequest($request)->isValid())
        {
          $em = $this->getDoctrine()->getManager();
          $em->persist($pref);
          $em->flush($pref);
          $flashBag->add("success", "Préférences enregistrées.");
        }
        else
        {
          $flashBag->add("error", "Erreur lors de l'enregistrement de vos préférences.");
        }
      }

      return $this->redirect($this->get("router")->generate("fos_user_profile_edit", array(
        "section" => "preferences"
      )));
    }
    else
    {
      throw new AccessDeniedException("Vous n'êtes pas authentifié.");
    }
  }
}
