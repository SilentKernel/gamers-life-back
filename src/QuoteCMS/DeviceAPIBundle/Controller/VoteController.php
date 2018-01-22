<?php

namespace QuoteCMS\DeviceAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class VoteController extends Controller
{
  const sessionID = "vote-post-";

  public function voteAction($postID, $value, Request $request)
  {
    $em = $this->getDoctrine()
                 ->getManager();

    $post = $em->getRepository("QuoteCMSPostBundle:Post")
               ->FindOneBy(array("id" => $postID));

    if ($post != null)
    {
      if ($value == "plus" or $value == "least")
      {
        $session = $request->getSession();
        if (!$session->has(self::sessionID . $postID))
        {
          $session->set(self::sessionID . $postID, true);

          if ($value == "plus")
            $post->setPlusOne($post->getPlusOne()+1);
          elseif ($value == "least")
            $post->setLeastOne($post->getLeastOne()+1);

            $em->persist($post);
            $em->flush();
            return new JsonResponse(array("success" => true));
        }
      }
    }
    return new JsonResponse(array("success" => false));
  }
}
