<?php
/**
 * User: Silent
 * Date: 10/08/2015
 * Time: 14:52
 */

namespace Silentkernel\CommentBundle\Twig;


class CountService extends \Twig_Extension
{
    const APCId = "skc-twig-";
    private $em;
    private $apc;

    public function getName()
    {
        return 'silentkernel_comment_get_count';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('comment_count_1', array($this, 'getCountContext1'), array() ),
            new \Twig_SimpleFilter('comment_count_2', array($this, 'getCountContext2'), array() ),
        );
    }

    public function __construct($doctrine, $apc)
    {
        $this->em = $doctrine->getManager();
        $this->apc = $apc;
    }

    private function getCount($context, $contextId)
    {
        $count = $this->apc->fetch(self::APCId . "-" . $context . "-" . $contextId);

        if ($count == null)
        {
            $count = $this
                ->em
                ->getRepository("SilentkernelCommentBundle:Topic")
                ->getCommentCount($context, $contextId);
            $this->apc->save(self::APCId . "-" . $context . "-" . $contextId, $count, 240);
        }

        return $count;
    }

    public function getCountContext1($contextId)
    {
        return $this->getCount(1, $contextId);
    }

    public function getCountContext2($contextId)
    {
        return $this->getCount(2, $contextId);
    }
}
