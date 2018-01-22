<?php

namespace QuoteCMS\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class MainController extends Controller
{

    const list_games_cache = 'gl-games-list';


    public function listAllAction()
    {
        $gamesIndexList = range('A', 'Z');
        //array_push($gamesIndexList,'#'); //Pour les autres characters

        $apc = $this->get("cache_APC");

        if (!$gamesList = $apc->fetch(self::list_games_cache)) // on vérifie si la variable est en cache
        {
            $em = $this->getDoctrine()->getManager();
            $games = $em->getRepository("QuoteCMSGameBundle:Game")
                ->getGamesWithPost();

            $gamesList =  array();
            foreach ($gamesIndexList as $l)
            {
                $gamesList[$l] = array(); //on set les sous tableaux
            }

            foreach ($games as $game)
            {
                $indexLetter = substr($game["ginfo"]["name"],0,1);
                $indexLetter = strtoupper($indexLetter);

                if (in_array ( $indexLetter , $gamesIndexList))
                {
                    array_push($gamesList[$indexLetter],$game);
                }
                /*else
                {
                    array_push($gamesList['#'],$game);
                }*/
            }

            $apc->save(self::list_games_cache, $gamesList, 3600); // on met en cache 1h
        }

        return $this->render('QuoteCMSGameBundle:List:List.html.twig',array(
            'games' => $gamesList,
            'gamesIndex' => $gamesIndexList
        ));
    }
}
