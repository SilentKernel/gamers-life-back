<?php

namespace QuoteCMS\ModeratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use QuoteCMS\PostBundle\Form\PostModeratorType;
use QuoteCMS\PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;


class FormPostController extends Controller
{
    public function PostFormAction($postId,Request $request)
    {
        $post = $this->getDoctrine()
            ->getManager()
            ->getRepository("QuoteCMSPostBundle:Post")
            ->findOneBy(array("id" => $postId));

        $form = $this->get('form.factory')->create(new PostModeratorType(), $post);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();


            // VALIDATION DES DONNEES

            $em->persist($post);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', '#GL publiée, merci');
            return $this->redirect($this->generateUrl('quote_cms_moderator_post',array('postId' => $post->getId())));
        }

        return $this->render('QuoteCMSModeratorBundle:Form:Post.html.twig', array(
            'form' => $form->createView(),
            'post' => $post));
    }
}
