<?php

namespace QuoteCMS\ModeratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Silentkernel\CommentBundle\Form\CommentModeratorType;
use Silentkernel\CommentBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;


class FormCommentController extends Controller
{
    public function CommentFormAction($commentId,Request $request)
    {
        // just a test of sublime text
        $comment = $this->getDoctrine()
            ->getManager()
            ->getRepository("SilentkernelCommentBundle:Comment")
            ->findOneBy(array("id" => $commentId));

        $form = $this->get('form.factory')->create(new CommentModeratorType(), $comment);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Commentaire validé, merci');
            return $this->redirect($this->generateUrl('quote_cms_moderator_index'));
        }

        return $this->render('QuoteCMSModeratorBundle:Form:Comment.html.twig', array(
            'form' => $form->createView(),
            'comment' => $comment));
    }
}
