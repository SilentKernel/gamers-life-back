<?php

namespace QuoteCMS\DeviceAPIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


class QuoteListController extends Controller
{
    const resultArray = "quotes";
    const gameArray = "games";
    const resultPerPage = 20;


    private function generatePostJson($posts)
    {
      $commentCounter = $this->get("silentkernel_comment.twig_counter");

      $resp = array();
      $i = 0;
      foreach ($posts as $post)
      {
          // Post data
          $resp[self::resultArray][$i]["id"] = $post->getId();
          $resp[self::resultArray][$i]["title"] = $post->getTitle();
          $resp[self::resultArray][$i]["slug"] = $post->getSlug();

          $resp[self::resultArray][$i]["story"] = str_replace("\n", "",
          $this->render("QuoteCMSPostBundle:Single:storyParse.html.twig",
          array("post" => $post))->getContent());

          $resp[self::resultArray][$i]["creationDate"] = $post->getCreationDate()->format('d/m/y');
          $resp[self::resultArray][$i]["plusOne"] = $post->getPlusOne();
          $resp[self::resultArray][$i]["leastOne"] = $post->getLeastOne();

          // in list, wee just need to knw if there is video
          /*if ($post->getVideoUrl() != null)
              $resp[self::resultArray][$i]["hasVideo"] = true;
          else
              $resp[self::resultArray][$i]["hasVideo"] = false;
          */

          // social
          $postShare = $post->getShareCount();
          $resp[self::resultArray][$i]["shareCount"] =
            $postShare->getFacebook() +
            $postShare->getTwitter()  +
            $postShare->getGoogle();

         // Comments
         $resp[self::resultArray][$i]["commentCount"] = $commentCounter->getCountContext1($post->getId());

          // General data
          $resp[self::resultArray][$i]["gId"] = $post->getGame()->getId();
          //$resp[self::resultArray][$i]["c_name"] = $post->getGame()->getCategory()->getName();

          // Who posted this ?
          if ($post->getAnonymous())
          {
              $resp[self::resultArray][$i]["author"] = "Anonyme";
          }
          else
          {
              $resp[self::resultArray][$i]["author"] = $post->getUser()->getNickname();
          }

          $postPictures = $post->getPictures();
          $picturesCount = $postPictures->count();
          if ($picturesCount > 0)
          {
            $resp[self::resultArray][$i]["hasPicture"] = true;
            $resp[self::resultArray][$i]["pictureCount"] = $picturesCount;
            $picLoop = 0;
            foreach ($postPictures as $picture)
            {
                $resp[self::resultArray][$i]["pictures"][$picLoop] = $picture->getFilename();
                $picLoop++;
            }
          }
          else
              $resp[self::resultArray][$i]["hasPicture"] = false;

          $i++;
      }

      return $resp;
    }

    private function generatePostPaginatedJson($query, $page, $isGeneral = false)
    {
        $page = intval($page);

        if ($page < 1)
            return array();

        $posts = $this->get('knp_paginator')->paginate(
            $query,
            $page,
            self::resultPerPage
        );

        $resp = $this->generatePostJson($posts->getItems());
        $resp["maxItems"] = $posts->getTotalItemCount();

        if ($page == 1 && $isGeneral)
        {
            $gamesDb = $this->getDoctrine()
                ->getManager()
                ->getRepository("QuoteCMSGameBundle:Game")->getGamesWithPost();

            $i = 0;
            foreach ($gamesDb as $oneResult)
            {
                $resp[self::gameArray][$i]["id"] = $oneResult["ginfo"]["id"];
                $resp[self::gameArray][$i]["name"] = ucwords($oneResult["ginfo"]["name"]);
                $resp[self::gameArray][$i]["slug"] = $oneResult["ginfo"]["slug"];
                $resp[self::gameArray][$i]["posts_count"] = $oneResult["postsCount"];
                $i++;
            }
        }

        return $resp;
    }

    public function globalPostAction($page)
    {
        return new JsonResponse($this->generatePostPaginatedJson($this
                ->getDoctrine()
                ->getEntityManager()
                ->getRepository("QuoteCMSPostBundle:Post")
                ->getAll(), $page, true));

    }

    public function firstPostAction($page)
    {
        return new JsonResponse($this->generatePostPaginatedJson($this
                ->getDoctrine()
                ->getEntityManager()
                ->getRepository("QuoteCMSPostBundle:Post")
                ->getPostsSinceOrigin(), $page, true));
    }

    public function plusOnePostAction($page)
    {
        return new JsonResponse($this->generatePostPaginatedJson($this
            ->getDoctrine()
            ->getEntityManager()
            ->getRepository("QuoteCMSPostBundle:Post")
            ->getByPlusOne(), $page, false));

    }

    public function leastOnePostAction($page)
    {
        return new JsonResponse($this->generatePostPaginatedJson($this
            ->getDoctrine()
            ->getEntityManager()
            ->getRepository("QuoteCMSPostBundle:Post")
            ->getByLeastOne(), $page, false));

    }

    public function getByGameIdAction($page, $gameId)
    {
        $gameId = intval($gameId);

        // Check given game id
        if ($gameId < 1)
            return new JsonResponse(array());

        return new JsonResponse($this->generatePostPaginatedJson($this
            ->getDoctrine()
            ->getEntityManager()
            ->getRepository("QuoteCMSPostBundle:Post")
            ->getByGameId($gameId), $page, false));
    }

    public function getRandomAction()
    {
      $posts = $this->get("quote_cms_post.random_tools")->getRandomPost(40);
      return new JsonResponse(
        $this->generatePostJson($posts)
      );
    }
}
