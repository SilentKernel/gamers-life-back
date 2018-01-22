<?php
/**
 * Created by PhpStorm.
 * User: Silent
 * Date: 06/08/2015
 * Time: 03:45
 */

namespace QuoteCMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

class PopOverController extends Controller
{
    const rUserList = "gl-u-l";
    public function usernamePopoverAction($user, $position, $originalRequest)
    {
        if ($originalRequest->attributes->has(self::rUserList))
        {
            $userList = $originalRequest->attributes->get(self::rUserList);
        }
        else
        {
            $userList = new ArrayCollection();
        }

        if ($userList->contains($user))
        {
            $showDiv = false;
        }
        else // add this user as already show in this request
        {
            $showDiv = true;
            $userList->add($user);
            $originalRequest->attributes->set(self::rUserList, $userList);
        }

        return $this->render("QuoteCMSUserBundle:Public:Username.html.twig",
            array(
                "user" => $user,
                "showDiv" => $showDiv,
                "position" => $position
            ));
    }
}