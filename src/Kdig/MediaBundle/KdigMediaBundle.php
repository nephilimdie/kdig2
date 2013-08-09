<?php

namespace Kdig\MediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KdigMediaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataMediaBundle';
    }
}
