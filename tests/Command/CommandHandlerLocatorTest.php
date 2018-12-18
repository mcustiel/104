<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Tests;

use Mcustiel\OneHundredFour\Command\CommandHandler;
use Mcustiel\OneHundredFour\Command\CommandHandlerLocator;
use Mcustiel\OneHundredFour\Command\Exceptions\CommandHandlerLocatorException;
use Mcustiel\OneHundredFour\HandlerIdentifier;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/** @covers \Mcustiel\OneHundredFour\Command\CommandHandlerLocator */
class CommandHandlerLocatorTest extends TestCase
{
    /** @var ContainerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $container;
    /** @var CommandHandlerLocator */
    private $locator;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->locator = new CommandHandlerLocator($this->container);
    }

    public function testLocatesAHandler(): void
    {
        $handler = $this->createMock(CommandHandler::class);
        $identifier = $this->createMock(HandlerIdentifier::class);
        $this->container->expects($this->once())
            ->method('has')
            ->with($this->identicalTo('potato'))
            ->willReturn(true);
        $this->container->expects($this->once())
            ->method('get')
            ->with($this->identicalTo('potato'))
            ->willReturn($handler);
        $identifier->expects($this->once())
            ->method('get')
            ->willReturn('potato');

        $this->assertSame($handler, $this->locator->locate($identifier));
    }

    public function testThrowsExceptionIfHandlerDoesNotExist(): void
    {
        $identifier = $this->createMock(HandlerIdentifier::class);
        $this->container->expects($this->once())
            ->method('has')
            ->with($this->identicalTo('potato'))
            ->willReturn(false);
        $this->container->expects($this->never())
            ->method('get');
        $identifier->expects($this->once())
            ->method('get')
            ->willReturn('potato');

        $this->expectException(CommandHandlerLocatorException::class);
        $this->expectExceptionMessage('Can not get instance of handler with id: potato');
        $this->locator->locate($identifier);
    }
}
