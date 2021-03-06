<?php

namespace Silentkernel\CommentBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    const limiteDateValidation = "-10 day";

    public function getComments($topic)
    {
        $query = $this->_em->createQuery("SELECT c
                        FROM SilentkernelCommentBundle:Comment c
                        JOIN c.topic t
                        WHERE t = :topic
                        AND c.validated = true
                        ORDER BY c.creationDate ASC ");

        $query->setParameter(":topic", $topic);
        $query->useQueryCache(true);

        return $query;
    }

    public function getNbCommentsByUser($user)
    {
        $query = $this->_em->createQuery(
            "SELECT count(c) AS nbComments ".
            "FROM QuoteCMSUserBundle:User u ".
            "JOIN SilentkernelCommentBundle:Comment c ".
            "WHERE u.id = :user_id ".
            "AND c.user = u.id ".
            "AND c.validated = true");
        $query->setParameter(":user_id",$user->getId());

        $query->useQueryCache(true);

        $result = $query = $query->getArrayResult();

        return $result[0]['nbComments'];
    }

    public function getNbNoValidateComments()
    {
        $limit_date =  new \DateTime("now");
        $limit_date->modify( self::limiteDateValidation);

        $query = $this->_em->createQuery(
            "SELECT count(c) AS nbComments ".
            "FROM SilentkernelCommentBundle:Comment c ".
            "WHERE c.creationDate >= :limiteDate ".
            "AND c.validated = false ".
            "AND c.deletedByModeration = false");
        $query->setParameter(":limiteDate",$limit_date);

        $query->useQueryCache(true);

        $result = $query = $query->getArrayResult();

        return $result[0]['nbComments'];
    }

    public function getNoValidateComments()
    {
        $limit_date =  new \DateTime("now");
        $limit_date->modify( self::limiteDateValidation);

        $query = $this->_em->createQuery(
            "SELECT c ".
            "FROM SilentkernelCommentBundle:Comment c ".
            "WHERE c.creationDate >= :limiteDate ".
            "AND c.validated = false ".
            "AND c.deletedByModeration = false");
        $query->setParameter(":limiteDate",$limit_date);
        $query->useQueryCache(true);

        $result = $query->getResult();

        return $result;
    }

    public function getReportComments()
    {
        $query = $this->_em->createQuery(
            "SELECT c ".
            "FROM SilentkernelCommentBundle:Comment c ".
            "WHERE c.deletedByModeration = false ".
            "AND c.reportCount != 0 ");
        $query->useQueryCache(true);

        $result = $query->getResult();

        return $result;
    }

    public function getNbReportComments()
    {
        $query = $this->_em->createQuery(
            "SELECT count(c) AS nbReports ".
            "FROM SilentkernelCommentBundle:Comment c ".
            "WHERE c.reportCount != 0".
            "AND c.deletedByModeration = false");
        $query->useQueryCache(true);

        $result = $query = $query->getArrayResult();

        return $result[0]['nbRpots'];
    }
}
