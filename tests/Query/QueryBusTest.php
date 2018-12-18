<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Tests;

use Mcustiel\OneHundredFour\HandlerIdentifier;
use Mcustiel\OneHundredFour\Query\Query;
use Mcustiel\OneHundredFour\Query\QueryBus;
use Mcustiel\OneHundredFour\Query\QueryHandler;
use Mcustiel\OneHundredFour\Query\QueryHandlerLocator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Mcustiel\OneHundredFour\Query\QueryBus */
class QueryBusTest extends TestCase
{
    /** @var QueryHandlerLocator|MockObject */
    private $locator;
    /** @var QueryBus */
    private $queryBus;

    protected function setUp(): void
    {
        $this->locator = $this->createMock(QueryHandlerLocator::class);
        $this->queryBus = new QueryBus($this->locator);
    }

    public function testDispatchesAQuery(): void
    {
        $query = $this->createMock(Query::class);
        $identifier = $this->createMock(HandlerIdentifier::class);
        $handler = $this->createMock(QueryHandler::class);

        $query->expects($this->once())
            ->method('getHandler')
            ->willReturn($identifier);
        $this->locator->expects($this->once())
            ->method('locate')
            ->with($this->identicalTo($identifier))
            ->willReturn($handler);
        $handler->expects($this->once())
            ->method('handle')
            ->with($this->identicalTo($query));

        $this->queryBus->dispatch($query);
    }
}
