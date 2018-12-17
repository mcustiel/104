<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Command;

use Mcustiel\OneHundredFour\Command\Exceptions\CommandHandlerException;

interface CommandHandler
{
    /** @throws CommandHandlerException */
    public function handle(Command $command): void;
}
