<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use QuoteCMS\PostBundle\Form\PostType;
use QuoteCMS\PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;


class FormController extends Controller
{
    public function PostFormAction(Request $request)
    {
        $ip = $this->container->get('request')->getClientIp();
        // Generate an unique ID form
        $postFormUniqueId = hash("sha256",
            $this->container->getParameter('secret').
            $ip.
            time().
            uniqid(rand(), true));

        $post = new Post($postFormUniqueId);
        $form = $this->get('form.factory')->create(new PostType(), $post);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $post->setIp($ip);

            $session = $request->getSession();
            if($session->has($post->getFormUId()))
            {
                $postPictureRep = $em->getRepository("QuoteCMSPostBundle:PostPicture");
                $picturesId = $session->get($post->getFormUId());
                foreach ($picturesId as $onePictureId)
                {
                    $onePicture = $postPictureRep->findOneById($onePictureId);
                    $onePicture->setToBeRemoved(false);
                    $em->persist($onePicture);
                    $post->addPicture($onePicture);
                }
                $session->remove($post->getFormUId());
            }

            $post->setDeviceType($this->get("quote_cms_device_api.service")->detectThisDevice($request));
            if ($post->getTempGameName() != null)
            {
                // Here we check if wee already own this game in db
                $oneGame = $em->getRepository("QuoteCMSGameBundle:Game")->findOneByName($post->getTempGameName());
                if ($oneGame != null)
                {
                    $post->setGame($oneGame);
                    $post->setTempGameName(null);
                }
            }

            $securityContext = $this->container->get('security.context');
            if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
            {
                $user = $user = $this->get('security.context')->getToken()->getUser();
                $post->setUser($user);
                $post->setAnonymous($user->getPref()->getAnonymousPost());
            }

            $em->persist($post);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Votre #GL a bien été enregistrée, merci.');
            return $this->redirect($this->generateUrl('quote_cms_core_homepage'));
        }

        return $this->render('QuoteCMSPostBundle:Form:Post.html.twig', array(
            'form' => $form->createView()));
    }
}
