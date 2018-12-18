<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Tests;

use Mcustiel\OneHundredFour\Query\OptionalResult;
use PHPUnit\Framework\TestCase;

/** @covers \Mcustiel\OneHundredFour\Query\OptionalResult */
class OptionalResultTest extends TestCase
{
    public function testReturnsPresentIfResultIsNotNull(): void
    {
        $optionalResult = new OptionalResult('potato');
        $this->assertTrue($optionalResult->isPresent());
    }

    public function testGetValueWhenPresent(): void
    {
        $optionalResult = new OptionalResult('potato');
        $this->assertSame('potato', $optionalResult->getResult());
    }

    public function testGetSameInstanceIfResultIsAnObject(): void
    {
        $object = new \stdClass();
        $optionalResult = new OptionalResult($object);
        $this->assertSame($object, $optionalResult->getResult());
    }

    public function testReturnsNotPresentIfResultIsNull(): void
    {
        $optionalResult = new OptionalResult(null);
        $this->assertFalse($optionalResult->isPresent());
    }

    public function testThrowsExceptionIfNotPresentAndGetValueIsCalled(): void
    {
        $optionalResult = new OptionalResult(null);
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('Trying to get value from an absent value');
        $optionalResult->getResult();
    }

    public function testCreateAbsentBuilderMethod(): void
    {
        $absentResult = OptionalResult::createAbsent();
        $this->assertFalse($absentResult->isPresent());
    }
}
