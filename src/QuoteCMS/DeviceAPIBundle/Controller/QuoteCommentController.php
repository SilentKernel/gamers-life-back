<?php

namespace QuoteCMS\DeviceAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuoteCommentController extends Controller
{
  const commentsArray = "comments";

  private function generateCommentJson($comments)
  {
    $result = array();
    $result["maxItems"] = $comments->getTotalItemCount();

    $i = 0;
    foreach ($comments->getItems() as $comment)
    {
      // id (used by "track by" in angular.js) !
      $result[self::commentsArray][$i]["id"] = $comment->getID();

      // date
      $result[self::commentsArray][$i]["creationDate"] = str_replace("\n", "",
      $this->render("SilentkernelCommentBundle:Single:DateDiff.html.twig",
      array("comment" => $comment))->getContent());

      // Author and avatar
      $result[self::commentsArray][$i]["author"] = $comment->getUser()->getNickName();
      if ($comment->getUser()->getAvatar() != null)
      {
        $result[self::commentsArray][$i]["authorHasAvatar"] = true;
        $result[self::commentsArray][$i]["authorAvatar"] = $comment->getUser()->getAvatar()->getFileName();
      }
      else
      {
        $result[self::commentsArray][$i]["authorHasAvatar"] = false;
      }

      // Message
      $result[self::commentsArray][$i]["message"] =
      str_replace(array("\n", "/bundles", 'a href='), array("", "bundles", 'a class = "comment-link" target="_system" href='), $this
      ->render("SilentkernelCommentBundle:Single:CommentMessage.html.twig",
      array("comment" => $comment))->getContent());
      $result[self::commentsArray][$i]["plusOne"] = $comment->getPlusOne();

      // Comment device type
      $deviceType = $comment->getDeviceType();
      if ($deviceType->getIdentifier() == "mobile_web" or $deviceType->getIdentifier() == "mobile_app")
      {
        $result[self::commentsArray][$i]["deviceType"] = "mobile";
      }
      elseif ($deviceType->getIdentifier() == "tablet_web" or $deviceType->getIdentifier() == "tablet_web")
      {
        $result[self::commentsArray][$i]["deviceType"] = "tablet";
      }
      elseif ($deviceType->getIdentifier() == "console_web" or $deviceType->getIdentifier() == "console_app")
      {
        $result[self::commentsArray][$i]["deviceType"] = "console";
      }
      else
      {
        $result[self::commentsArray][$i]["deviceType"] = "computer";
      }

      // Parent Comment
      $parentComment = $comment->getParentComment();
      if ($parentComment != null)
      {
        $result[self::commentsArray][$i]["hasParent"] = true;
        $result[self::commentsArray][$i]["parent"]["author"] = $parentComment->getUser()->getNickName();
        $result[self::commentsArray][$i]["parent"]["message"] =
        str_replace(array("\n", "/bundles", 'a href='), array("", "bundles", 'a class = "comment-link" target="_system" href='),
        $this->render("SilentkernelCommentBundle:Single:CommentMessage.html.twig",
        array("comment" => $parentComment))->getContent());
      }
      else
      {
        $result[self::commentsArray][$i]["hasParent"] = false;
      }

      $i++;
    }
    return $result;
  }

  public function getQuoteCommentAction($postID, $page)
  {
    $page = intval($page);
    if ($page > 0)
    {
      $comments = $this
      ->get("silentkernel_comment.service")
      ->getCommentsPage(1, $postID, $page);

      if ($comments != null)
      {
        return new JsonResponse($this->generateCommentJson($comments));
      }
    }
    return new JsonResponse(array());
  }

  public function reportCommentAction($commentID)
  {
    $em = $this->getDoctrine()->getManager();
    $comment = $em->getRepository("SilentkernelCommentBundle:Comment")->findOneById($commentID);
    if ($comment == null)
    {
      return new JsonResponse(array("success" => false));
    }
    else
    {
      $comment->setReportCount($comment->getReportCount()+1);
      $em->persist($comment);
      $em->flush();
      return new JsonResponse(array("success" => true));
    }
  }
}
