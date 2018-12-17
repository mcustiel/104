<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Query;

use Mcustiel\OneHundredFour\Query\Exceptions\QueryHandlerException;
use Mcustiel\OneHundredFour\Query\Exceptions\QueryHandlerLocatorException;

class QueryBus
{
    /**
     * @var QueryHandlerLocator
     */
    private $handlerLocator;

    public function __construct(QueryHandlerLocator $locator)
    {
        $this->handlerLocator = $locator;
    }

    /**
     * @throws QueryHandlerException
     * @throws QueryHandlerLocatorException
     */
    public function dispatch(Query $query)
    {
        $handler = $this->handlerLocator->locate($query->getHandler());

        return $handler->handle($query);
    }
}
