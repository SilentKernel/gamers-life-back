<?php

namespace QuoteCMS\UserBundle\Controller;

use QuoteCMS\UserBundle\Form\AvatarType;
use QuoteCMS\UserBundle\Entity\Avatar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;




class AvatarController extends Controller
{

    public function showFormAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user->getOAuth()){
            throw new AccessDeniedException("Votre avatar est gérré par ". $user->getOAuthOwner());
        }

        $avatar = new Avatar();
        $form = $this->get('form.factory')->create(new AvatarType, $avatar);

        if ($form->handleRequest($request)->isValid())
        {
            $jsonArray = $this->get('quote_cms_core_upload_validator')
                ->isValid($avatar->getFile());

            if ($jsonArray["success"])
            {
                $this->get('stof_doctrine_extensions.uploadable.manager')
                    ->markEntityToUpload($avatar, $avatar->getFile());
                $em = $this->getDoctrine()->getManager();
                $em->persist($avatar);

                // remove old Avatar if there is one and link the
                // new one to the user
                $this->get("quotecms_user.avatar_tool")->removeAvatar($user);

                $user->setAvatar($avatar);
                $em->persist($user);
                $em->flush();

                $this->container
                ->get('liip_imagine.controller')
                ->filterAction($request, $avatar->__toString(), 'avatar_70');
            }

            return new JsonResponse($jsonArray);
        }


        return $this->render('QuoteCMSUserBundle:Avatar:formModal.html.twig',
            array('form' => $form->createView()));
    }

    function showAvatarSectionAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ($user->getOAuth()){
            throw new AccessDeniedException("Votre avatar est gérré par ". $user->getOAuthOwner());
        }
        return $this->render('QuoteCMSUserBundle:Avatar:avatarSection.html.twig',
            array('user' => $user));
    }

}
