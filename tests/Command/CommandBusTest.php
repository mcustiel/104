<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Tests;

use Mcustiel\OneHundredFour\Command\Command;
use Mcustiel\OneHundredFour\Command\CommandBus;
use Mcustiel\OneHundredFour\Command\CommandHandler;
use Mcustiel\OneHundredFour\Command\CommandHandlerLocator;
use Mcustiel\OneHundredFour\HandlerIdentifier;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CommandBusTest extends TestCase
{
    /** @var CommandHandlerLocator|MockObject */
    private $locator;
    /** @var CommandBus */
    private $commandBus;

    protected function setUp(): void
    {
        $this->locator = $this->createMock(CommandHandlerLocator::class);
        $this->commandBus = new CommandBus($this->locator);
    }

    public function testDispatchesACommand(): void
    {
        $command = $this->createMock(Command::class);
        $identifier = $this->createMock(HandlerIdentifier::class);
        $handler = $this->createMock(CommandHandler::class);

        $command->expects($this->once())
            ->method('getHandler')
            ->willReturn($identifier);
        $this->locator->expects($this->once())
            ->method('locate')
            ->with($this->identicalTo($identifier))
            ->willReturn($handler);
        $handler->expects($this->once())
            ->method('handle')
            ->with($this->identicalTo($command));

        $this->commandBus->dispatch($command);
    }
}
