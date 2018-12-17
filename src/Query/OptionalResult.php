<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Query;

class OptionalResult
{
    /** @var mixed */
    private $result;

    public function __construct($result = null)
    {
        $this->result = $result;
    }

    public function isPresent(): bool
    {
        return null !== $this->result;
    }

    /** @return mixed */
    public function getResult()
    {
        if (null === $this->result) {
            throw new \BadMethodCallException('Trying to get value from an absent value');
        }

        return $this->result;
    }

    public static function createAbsent()
    {
        return new static();
    }
}
