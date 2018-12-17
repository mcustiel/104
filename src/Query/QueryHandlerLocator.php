<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Query;

use Mcustiel\OneHundredFour\HandlerIdentifier;
use Mcustiel\OneHundredFour\Query\Exceptions\QueryHandlerLocatorException;
use Mcustiel\OneHundredFour\Query\Exceptions\UnregisteredQueryHandlerException;
use Psr\Container\ContainerInterface;

class QueryHandlerLocator
{
    /** @var ContainerInterface */
    private $creator;

    public function __construct(ContainerInterface $creator)
    {
        $this->creator = $creator;
    }

    /** @throws QueryHandlerLocatorException */
    public function locate(HandlerIdentifier $identifier): QueryHandler
    {
        $stringIdentifier = $identifier->get();
        $this->ensureHandlerExists($stringIdentifier);

        return $this->creator->get($stringIdentifier);
    }

    /** @throws UnregisteredQueryHandlerException */
    private function ensureHandlerExists(string $stringIdentifier)
    {
        if (!$this->creator->has($stringIdentifier)) {
            throw new UnregisteredQueryHandlerException(
                'Can not get instance of handler with id: ' . $stringIdentifier
            );
        }
    }
}
