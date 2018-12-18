<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Tests;

use Mcustiel\OneHundredFour\HandlerIdentifier;
use Mcustiel\OneHundredFour\Query\Exceptions\QueryHandlerLocatorException;
use Mcustiel\OneHundredFour\Query\QueryHandler;
use Mcustiel\OneHundredFour\Query\QueryHandlerLocator;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/** @covers \Mcustiel\OneHundredFour\Query\QueryHandlerLocator */
class QueryHandlerLocatorTest extends TestCase
{
    /** @var ContainerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $container;
    /** QueryHandlerLocator */
    private $locator;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->locator = new QueryHandlerLocator($this->container);
    }

    public function testLocatesAHandler(): void
    {
        $handler = $this->createMock(QueryHandler::class);
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

        $this->expectException(QueryHandlerLocatorException::class);
        $this->expectExceptionMessage('Can not get instance of handler with id: potato');
        $this->locator->locate($identifier);
    }
}
