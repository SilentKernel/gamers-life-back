<?php
namespace QuoteCMS\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class gAutoCompletionController extends controller {

    public function getKnownGameAEAction()
    {
        $games = $this->getDoctrine()
            ->getManager()
            ->getRepository("QuoteCMSGameBundle:Game")
            ->getAllNames();

        $result = array();
        if ($games != null)
        {
            foreach($games as $oneGame)
            {
                $result[]["v"] = $oneGame["name"];
            }
        }

        return new JsonResponse($result);
    }
}