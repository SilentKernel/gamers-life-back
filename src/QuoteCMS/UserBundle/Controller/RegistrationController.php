<?php

namespace QuoteCMS\UserBundle\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\UserBundle\Controller\RegistrationController as FoSBaseRegistrationController;

class RegistrationController extends FoSBaseRegistrationController
{
    // Need it cause we don't use twig to handle form error ...
    // TODO: Put it in his own service
    private function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }

    public function registerAction()
    {
        $request = $this->container->get('request');
         // if it's not an Ajax call we redirect request to FoS
        if (!$request->isXmlHttpRequest()) {
            return parent::registerAction();
        // else we handle request to respond to front end.
        } else
        { //*/

            $form = $this->container->get('fos_user.registration.form');

            $formHandler = $this->container->get('fos_user.registration.form.handler');
            $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

            $process = $formHandler->process($confirmationEnabled);
            if ($process) {
                $result["success"] = true;
                $result["mailConfirmation"] = $confirmationEnabled;
                $user = $form->getData();
                $authUser = false;

                if ($confirmationEnabled) {
                    $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                    // Remember, here twig is not here to wash our mistakes
                    // even if email is controlled by HTML5 attribut and should be validated by formHandler
                    $result["message"] = "Un email de confirmation a été envoyé à l'adresse: ". htmlspecialchars($user->getEmail());
                } else {
                    $result["message"] = "Vous êtes maintenant enregistré et connecté";
                    $authUser = true;
                }

                $response = new JsonResponse($result);
                if ($authUser) {
                    $this->authenticateUser($user, $response);
                }

                return $response;
            }

            // Here We check if there is error in Form.
            $errors = $this->getErrorMessages($form);
            if (isset($errors["username"]["0"])){
                $result["success"] = false;
                $result["usernameError"] = $errors["username"]["0"];
            }
            if (isset($errors["email"]["0"])){
                $result["success"] = false;
                $result["emailError"] = $errors["email"]["0"];
            }
            if (isset($errors["plainPassword"]["first"]["0"])){
                $result["success"] = false;
                $result["passwordError"] = $errors["plainPassword"]["first"]["0"];
            }

            if (isset($result["success"]) && !$result["success"]) {
                // Fuck there is a problem ... :(
                //$result["csrf"] = $this->container->get('form.csrf_provider')->generateCsrfToken("registration");
                return new JsonResponse($result);
            }

            // In this case, first call to /register via Get
            return $this->container->get('templating')->renderResponse(
                'QuoteCMSUserBundle:Registration:registerModal.html.twig',
                array("form" => $form->createView()));
        }
    }
}
