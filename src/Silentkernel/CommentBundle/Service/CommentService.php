<?php

/**
 * Created by PhpStorm.
 * User: Silentkernel
 * Date: 01/08/2015
 * Time: 01:10
 */

namespace Silentkernel\CommentBundle\Service;

use Silentkernel\CommentBundle\Entity\Topic;


class CommentService
{
    private $em;
    private $paginator;
    private $securityContext;

    const privateKey = "&kvlDVa>M-xVfEO^"; // This key is used to prevent Nav sedning shit too controller wich need route and param
    const topic = "topic";
    const comment = "comment";

    public function __construct($doctrine, $knpPaginator, $securityContext)
    {
        $this->em = $doctrine->getManager();
        $this->paginator = $knpPaginator;
        $this->securityContext = $securityContext;
    }

    private function signData($data)
    {
        return hash("sha256", $data . self::privateKey);
    }

    public function isWellSigned($data, $signature)
    {
        return ($signature == $this->signData($data));
    }

    public function generateCommentPage($context, $contextId, $request, $route = null, $routeParam = null)
    {
        $result[self::topic] = $this
            ->em
            ->getRepository("SilentkernelCommentBundle:Topic")
            ->findOneBy(array("context" => $context,
                "contextId" => $contextId));

        if ($result[self::topic] == null)
        {
            $result[self::topic] = new Topic();
            $result[self::topic]->setContext($context);
            $result[self::topic]->setContextId($contextId);
            $this->em->persist($result[self::topic]);
            $this->em->flush();
        }

        $result[self::comment] = $this->paginator->paginate(
            $this
                ->em
                ->getRepository("SilentkernelCommentBundle:Comment")
                ->getComments($result[self::topic]),
            $request->query->getInt('page', 1),
            20
        );

        // Custom template to change link
        $result[self::comment]->setTemplate("SilentkernelCommentBundle:Pagination:Paginator.html.twig");

        $isGranted = $this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED');
        if ($route != null)
        {
            $result[self::comment]->setUsedRoute($route);
            if (!$isGranted)
                $result["route"] = $route;
        }

        if ($routeParam != null)
        {
            foreach($routeParam as $key => $value)
            {
                $result[self::comment]->setParam($key, $value);
            }
            if (!$isGranted)
                $result["routeParam"] = base64_encode(serialize($routeParam));
        }

        if ($routeParam != null && $route != null && !$isGranted)
        {
            $result["routeSignature"] = $this->signData($result["route"] . $result["routeParam"]);
        }

        return $result;
    }

    public function getCommentsPage($context, $contextId, $page)
    {
      $topic = $this->em->getRepository("SilentkernelCommentBundle:Topic")
      ->findOneBy(array("context" => $context, "contextId" => $contextId));
      if ($topic != null)
      {
        return $this->paginator->paginate(
            $this->em->getRepository("SilentkernelCommentBundle:Comment")
                ->getComments($topic), $page, 20);
      }
      return null;
    }
}
