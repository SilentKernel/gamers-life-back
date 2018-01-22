<?php

namespace QuoteCMS\PostBundle\Service;

use QuoteCMS\PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;


class VoteTools {

    const browerCanVoteCookie = "BCN";

    private $em;
    private $localStorageArray;
    private $goddRequestMethod = true;

    public function __construct($doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    public function postVote(Post $post, $value)
    {
        if ($value == 1)
        {
            $post->setPlusOne($post->getPlusOne() + 1);
        }
        elseif($value == -1)
        {
            $post->setLeastOne($post->getLeastOne() + 1);
        }
        $this->em->persist($post);
        $this->em->flush($post);
    }

    public function generateLocalStorageArray(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            $clientLocalStorage = $request->request->get('lstorage');
            if (($clientLocalStorage != null) && ($clientLocalStorage != ""))
            {
                // The guy tried to put something shitly here ? so to prevent crash, try => catch !
                try
                {
                    $this->localStorageArray = json_decode(base64_decode($clientLocalStorage, true));
                }
                catch (\Exception $e)
                {
                    $this->localStorageArray = array();
                }
            }
            else
            {
                $this->localStorageArray = array();
            }
        }
        else
        {
            $this->goddRequestMethod = false;
        }
    }

    private function encodeCookieForResponse()
    {
        return base64_encode(json_encode($this->localStorageArray));
    }

    public function voteWithLocalStorage($post, $value)
    {
        $this->postVote($post, $value);
        $this->localStorageArray[] = $post->getId();
        return $this->encodeCookieForResponse();
    }

    public function voteWithUser($post, $value, $user)
    {
        $this->postVote($post, $value);
        $user->addVotedPost($post);
        $this->em->persist($user);
        $this->em->flush($user);
    }

    public function checkBrowser($cookies)
    {
        $result = false;
        if ($cookies->has(self::browerCanVoteCookie))
        {
            if (intval($cookies->get(self::browerCanVoteCookie)) == 1)
                $result = true;
        }
        return $result;
    }

    public function checkValue($value)
    {
        if ($value == 1 || $value == -1)
            return true;
        else
            return false;
    }

    public function checkLocalStorageCanVote(Post $post)
    {
        if ($this->goddRequestMethod)
        {
            return !in_array($post->getId(), $this->localStorageArray);
        }
        else
            return false;
    }
}