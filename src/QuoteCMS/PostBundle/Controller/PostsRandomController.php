<?php

namespace QuoteCMS\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class PostsRandomController extends Controller
{
    public function showPostsAction()
    {
        $posts = $this->get("quote_cms_post.random_tools")->getRandomPost(20);

        //On a enfin une belle salade mélanger à renvoyer à la vue
        return $this->render('QuoteCMSPostBundle:List:ListRandom.html.twig', array(
            'posts' => $posts
        ));
    }
}
