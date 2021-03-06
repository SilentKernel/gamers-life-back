<?php

namespace QuoteCMS\GameBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * GameRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GameRepository extends EntityRepository
{
    const baseQuery = "SELECT g.id, g.name FROM QuoteCMSGameBundle:Game g ";

    public function getAllNames()
    {
        $query = $this->_em
            ->createQuery(self::baseQuery . "ORDER BY g.name ASC");

        $query->useQueryCache(true);
        $query->useResultCache(true, 300);

        return $query->getArrayResult();
    }

    public function alreadyInDB($testName)
    {
        $result = false;
        $testName = strtolower($testName);
        $games = $this->getAllNames();

        $arrayLength = sizeof($games) - 1;
        $i = 0;

        while ($i <= $arrayLength and $result == false)
        {
            if (strtolower($games[$i]["name"]) == $testName)
                $result = true;
            $i++;
        }

        return $result;
    }

    public function getGamesWithPost()
    {
        $query = $this->_em->createQuery("
        SELECT g as ginfo, count(p.id) as postsCount
        FROM QuoteCMSGameBundle:Game g
        JOIN g.posts p
        WHERE p is not NULL
        GROUP BY g
        ORDER BY g.name ASC
        ");

        $query->useQueryCache(true);
        $query->useResultCache(true, 300);

        return $query->getArrayResult();
    }
}
