<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Tests;

use Mcustiel\OneHundredFour\HandlerIdentifier;
use PHPUnit\Framework\TestCase;

/** @covers \Mcustiel\OneHundredFour\HandlerIdentifier */
class HandlerIdentifierTest extends TestCase
{
    public function testGetIdentifier(): void
    {
        $optionalResult = new HandlerIdentifier('potato');
        $this->assertSame('potato', $optionalResult->get());
    }

    public function testThrowsExceptionIfCreatingWithEmptyIdentifier(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Empty identifier name');
        new HandlerIdentifier('');
    }
}
