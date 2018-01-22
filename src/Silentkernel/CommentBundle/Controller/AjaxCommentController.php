<?php

namespace Silentkernel\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silentkernel\CommentBundle\Form\CommentType;
use Silentkernel\CommentBundle\Entity\Comment;

class AjaxCommentController extends Controller
{
  const sessionReport = "sk-com-rep-";

  public function userDeleteCommentAction(Comment $comment)
  {
    $securityContext = $this->get("security.context");
    if ($securityContext->isGranted("IS_AUTHENTICATED_REMEMBERED"))
    {
      $user = $securityContext->getToken()->getUser();
      if ($user === $comment->getUser())
      {
        if ($comment->getDeletedByUser() == false)
        {
          $comment->setDeletedByUser(true);
          $em = $this->getDoctrine()->getManager();
          $em->persist($comment);
          $em->flush($comment);
          return new JsonResponse(array("success" => true, "message" => "Commentaire supprimé."));
        }
        else
        {
          return new JsonResponse(array("success" => false, "message" => "Commentaire déjà supprimé."));
        }
      }
      else
      {
        return new JsonResponse(array("success" => false, "message" => "Ce n'est pas votre commentaire."));
      }
    }
    return new JsonResponse(array("success" => false, "message" => "Vous n'êtes pas authentifié."));
  }

  public function reportAction(Comment $comment, Request $request)
  {
    $session = $request->getSession();
    $securityContext = $this->get("security.context");

    if ($securityContext->isGranted("IS_AUTHENTICATED_REMEMBERED"))
    {
      $user = $securityContext->getToken()->getUser();

      if ($user == $comment->getUser())
      {
        return new JsonResponse(array(
          "success" => false,
          "message" => "Vous ne pouvez pas vous signaler vous même :o."
        ));
      }
      elseif (!$session->has(self::sessionReport . $comment->getId()))
      {
        $session->set(self::sessionReport . $comment->getid(), true);
        $comment->setReportCount($comment->getReportCount() + 1 );
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();
        return new JsonResponse(array("success" => true));
      }
      else
      {
        return new JsonResponse(array(
          "success" => false,
          "message" => "Vous avez déjà signalé ce commentaire."
        ));
      }
    }
    return new JsonResponse(array("success" => false, "message" => "Vous n'êtes pas authentifié."));
  }

  public function refreshCommentGeneralDivAction($context, $contextId, $routeId, $routeParam, $routeSignature, Request $request)
  {
    try {
      $commentService = $this->get("silentkernel_comment.service");

      if ($commentService->isWellSigned($routeId . $routeParam, $routeSignature))
      {
        $routeParamArray = unserialize(base64_decode($routeParam));
        $commentData =
        $commentService
        ->generateCommentPage($context, $contextId, $request, $routeId, $routeParamArray);

        return $this->render("SilentkernelCommentBundle:General:CommentsGeneralDiv.html.twig", array(
          'commentData' => $commentData
        ));
      }
      // Integrity check fail :( Someone try to find a breach
      else
      {
        return new Response("<b>Un erreur est survenue lors de la verification de la requête de votre navigateur.</b>");
      }

    }
    catch (\Exception $e)
    {
      return new Response("Erreur 418 - Je suis une théière je ne sais pas faire ça !");
    }

  }

  public function addCommentFormAction($context, $contextId, $commentParent, Request $request)
  {
    $securityContext = $this->container->get('security.context');
    if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
    {
      $em = $this->getDoctrine()->getManager();
      $topic = $em
      ->getRepository("SilentkernelCommentBundle:Topic")->findOneBy(array(
        "context" => $context,
        "contextId" => $contextId
      ));

      if ($topic != null)
      {
        $parentEntity = null;
        // return 0 if shit in entenred
        $commentParent = intval($commentParent);

        if ($commentParent > 0)
        {
          $parentEntity = $em
          ->getRepository("SilentkernelCommentBundle:Comment")
          ->findOneById($commentParent);

          if ($parentEntity->getTopic() != $topic)
          {
            $parentEntity = null;
          }
        }

        $user = $securityContext->getToken()->getUser();
        $comment = new Comment();
        $form = $this->get('form.factory')->create(new CommentType(), $comment);
        if ($request->isMethod("POST"))
        {
          if ($form->handleRequest($request)->isValid())
          {
            $status = $this->get("silentkernel_comment.validator")->isValid($comment);
            if ($status["Status"] != "ERROR")
            {
              $comment->setTopic($topic);
              $comment->setDeviceType($this->get("quote_cms_device_api.service")->detectThisDevice($request));
              $comment->setUser($user);
              $comment->setIpAdress($request->getClientIp());

              if ($parentEntity != null)
              {
                $comment->setParentComment($parentEntity);
              }

              if ($status["Status"] != "OK")
              {
                $comment->setValidated(false);
              }

              $em->persist($comment);
              $em->flush();

              if ($status["Status"] == "OK")
              {
                $status["commentDiv"] = $this->render('SilentkernelCommentBundle:Single:Single.html.twig', array(
                  "comment" => $comment
                ))->getContent();
              }
            }

            return new JsonResponse($status);
          }
        }
        else
        {
          return $this->render("SilentkernelCommentBundle:Ajax:AddComment.html.twig", array(
            "form" => $form->createView(),

            "context" => $context,
            "contextId" => $contextId,
            "parentId" => $commentParent,
            "parentEntity" => $parentEntity,
            "user" => $user
          ));
        }
      }
    }
    // Nothing to do here
    return new Response("");
  }
}
