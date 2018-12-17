<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Command;

use Mcustiel\OneHundredFour\Command\Exceptions\CommandHandlerLocatorException;
use Mcustiel\OneHundredFour\Command\Exceptions\UnregisteredCommandHandlerException;
use Mcustiel\OneHundredFour\HandlerIdentifier;
use Psr\Container\ContainerInterface;

class CommandHandlerLocator
{
    /** @var ContainerInterface */
    private $creator;

    public function __construct(ContainerInterface $creator)
    {
        $this->creator = $creator;
    }

    /** @throws CommandHandlerLocatorException */
    public function locate(HandlerIdentifier $identifier): CommandHandler
    {
        $stringIdentifier = $identifier->get();
        $this->ensureHandlerExists($stringIdentifier);

        return $this->creator->get($stringIdentifier);
    }

    /** @throws UnregisteredCommandHandlerException */
    private function ensureHandlerExists(string $stringIdentifier)
    {
        if (!$this->creator->has($stringIdentifier)) {
            throw new UnregisteredCommandHandlerException(
                'Can not get instance of handler with id: ' . $stringIdentifier
            );
        }
    }
}
