<?php

namespace QuoteCMS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class QuoteCMSUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
