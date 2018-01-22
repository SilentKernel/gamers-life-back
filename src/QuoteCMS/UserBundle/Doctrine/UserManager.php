<?php

namespace QuoteCMS\UserBundle\Doctrine;

use FOS\UserBundle\Doctrine\UserManager as FoSBasUserManager;

class UserManager extends FoSBasUserManager
{
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL))
        {
            $user = $this->findUserByEmail($usernameOrEmail);
        }

        if (!isset($user))
        {
            $user = $this->findUserByUsername($usernameOrEmail);
        }

        if ($user != null && !$user->getOAuth())
            return $user;
        else
            return null;
    }
}
