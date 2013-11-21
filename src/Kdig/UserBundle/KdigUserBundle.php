<?php

namespace Kdig\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KdigUserBundle extends Bundle
{
    public function getParent()
    {
        return 'SonataUserBundle';
    }
}
