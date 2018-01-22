<?php

namespace QuoteCMS\UserBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;


class UserStatsExtension extends \Twig_Extension
{
    private $em;
    private $apc;

    const forum_life_cache = 'gl-f-';



    public function __construct( $doctrine,$apc){
        $this->em = $doctrine->getManager();
        $this->apc = $apc;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('glPosts', array($this, 'glPostsFilter')),
            new \Twig_SimpleFilter('glComments', array($this, 'glCommentsFilter')),
            new \Twig_SimpleFilter('glLikes', array($this, 'glLikesFilter')),
            new \Twig_SimpleFilter('forumPosts', array($this, 'forumPostsFilter')),
            new \Twig_SimpleFilter('forumReply', array($this, 'forumReplyFilter')),
            new \Twig_SimpleFilter('forumLikes', array($this, 'forumLikesFilter')),
        );
    }

    public function glPostsFilter($user)
    {
        $posts = $this->em->getRepository('QuoteCMSPostBundle:Post')->getNbPostsByUser($user);
        return $posts;
    }

    public function glLikesFilter($user)
    {
        $likes = $this->em->getRepository('QuoteCMSPostBundle:Post')->getNbLikesByUser($user);
        return $likes;
    }

    public function glCommentsFilter($user)
    {
        $comments = $this->em->getRepository('SilentkernelCommentBundle:Comment')->getNbCommentsByUser($user);
        return $comments;
    }

    private function forumInfo($user)
    {
        if (!$forum = $this->apc->fetch(self::forum_life_cache.$user->getId()))
        {
            $forum_file = 'https://forum.gamers-life.fr/users/by-external/'.$user->getSSOId().'.json';
            /*
                    LIKE                = 1
                    WAS_LIKED           = 2
                    BOOKMARK            = 3
                    NEW_TOPIC           = 4
                    REPLY               = 5
                    RESPONSE            = 6
                    MENTION             = 7
                    QUOTE               = 9
                    EDIT                = 11
                    NEW_PRIVATE_MESSAGE = 12
                    GOT_PRIVATE_MESSAGE = 13
                    PENDING             = 14
            */

            try {
                $forum = array('posts'=>'0', 'reply'=>'0', 'likes'=>'0');
                $forumJson = json_decode(file_get_contents($forum_file, true));


                foreach ($forumJson->{'user'}->{'stats'} as $item) {
                    if ($item->action_type == "4") {
                        $forum['posts'] = $item->{'count'};
                    } elseif ($item->action_type == "5") {
                        $forum['reply'] = $item->{'count'};
                    } elseif ($item->action_type == "2") {
                        $forum['likes'] = $item->{'count'};
                    }
                }
                $this->apc->save(self::forum_life_cache . $user->getId(), $forum, 3600);

            }
            catch (\Exception $e)
            {$forum = array('posts'=>'0', 'reply'=>'0', 'likes'=>'0');}

        }
        return $forum;

    }

    public function forumPostsFilter($user)
    {
        return $this->forumInfo($user)['posts'];
    }

    public function forumReplyFilter($user)
    {
        return $this->forumInfo($user)['reply'];
    }

    public function forumLikesFilter($user)
    {
        return $this->forumInfo($user)['likes'];
    }

    public function getName()
    {
        return 'quotecms_user_stats_extension';
    }
}