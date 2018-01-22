<?php

namespace QuoteCMS\ModeratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Silentkernel\CommentBundle\Form\ReportCommentModeratorType;
use Silentkernel\CommentBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;


class FormReportCommentController extends Controller
{
    public function ReportCommentFormAction($commentId,Request $request)
    {
        $comment = $this->getDoctrine()
            ->getManager()
            ->getRepository("SilentkernelCommentBundle:Comment")
            ->findOneBy(array("id" => $commentId));

        $form = $this->get('form.factory')->create(new ReportCommentModeratorType(), $comment);

        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Commentaire validé, merci');
            return $this->redirect($this->generateUrl('quote_cms_moderator_index'));
        }

        return $this->render('QuoteCMSModeratorBundle:Form:ReportComment.html.twig', array(
            'form' => $form->createView(),
            'comment' => $comment));
    }
}
