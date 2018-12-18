<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour;

class HandlerIdentifier
{
    /**
     * @var string
     */
    private $identifier;

    public function __construct(string $identifier)
    {
        $this->ensureNotEmpty($identifier);
        $this->identifier = $identifier;
    }

    public function get(): string
    {
        return $this->identifier;
    }

    /** @throws \InvalidArgumentException */
    private function ensureNotEmpty(string $identifier): void
    {
        if (empty($identifier)) {
            throw new \InvalidArgumentException('Empty identifier name');
        }
    }
}
