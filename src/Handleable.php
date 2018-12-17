<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour;

interface Handleable
{
    public function getHandler(): HandlerIdentifier;
}
