<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Command;

use Mcustiel\OneHundredFour\Command\Exceptions\CommandHandlerException;
use Mcustiel\OneHundredFour\Command\Exceptions\CommandHandlerLocatorException;

class CommandBus
{
    /**
     * @var CommandHandlerLocator
     */
    private $handlerLocator;

    public function __construct(CommandHandlerLocator $locator)
    {
        $this->handlerLocator = $locator;
    }

    /**
     * @throws CommandHandlerException
     * @throws CommandHandlerLocatorException
     */
    public function dispatch(Command $command): void
    {
        $handler = $this->handlerLocator->locate($command->getHandler());

        $handler->handle($command);
    }
}
