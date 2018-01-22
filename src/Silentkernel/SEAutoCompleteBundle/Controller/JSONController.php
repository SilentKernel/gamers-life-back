<?php

namespace Silentkernel\SEAutoCompleteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class JSONController extends Controller
{
    CONST GoogleUrl = "http://suggestqueries.google.com/complete/search?client=firefox&q=";
    CONST cacheID = "skrnl-seac-";

    private function shouldFilterThisRep($word)
    {
        $word = strtolower($word);
        $badwords = ["amazon", 
                     "google", 
                     "gmail", 
                     "walmart", 
                     "xbox", 
                     "cheats", 
                     "cheat", 
                     "cheating", 
                     "gameplay", 
                     "review", 
                     "mods",
                     "le bon coin"]; // lol
        $result = false;

        foreach($badwords as $oneBadWord)
        {
            if (strpos($word,$oneBadWord) !== false)
                $result = true;
        }

        return $result;
    }

    public function getGoogleResponseAction($keywords)
    {
        $keywords = strtolower($keywords);
        $apc = $this->get("cache_APC");

        $arrayResult = $apc->fetch(self::cacheID.$keywords);
        if ($arrayResult != false)
        {
            return new JsonResponse($arrayResult);
        }

        $googleResult = file_get_contents(self::GoogleUrl . urlencode($keywords));
        if ($googleResult != false)
        {
            $googleArrayResult = json_decode($googleResult);
            $arrayResult = array();

            $GamesRep = $this->getDoctrine()
                ->getManager()
                ->getRepository("QuoteCMSGameBundle:Game");

            foreach($googleArrayResult[1] as $oneWord)
            {
                /* this part need to be modified for other project, cause wee will check if
                we does not already own this game in our DB
                */
                if (!$GamesRep->alreadyInDB($oneWord) and !$this->shouldFilterThisRep($oneWord))
                {
                    $arrayResult[]["v"] = ucfirst($oneWord);
                }
            }

            $apc->save(self::cacheID.$keywords, $arrayResult, 604800); // keep it for one week
            return new JsonResponse($arrayResult);
        }
        return new JsonResponse(array());
    }
}
