<?php

namespace Pi\FrontBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PiFrontBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
