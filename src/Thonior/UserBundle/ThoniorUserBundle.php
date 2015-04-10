<?php

namespace Thonior\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ThoniorUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}