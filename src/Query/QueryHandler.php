<?php

declare(strict_types=1);

namespace Mcustiel\OneHundredFour\Query;

use Mcustiel\OneHundredFour\Query\Exceptions\QueryHandlerException;

interface QueryHandler
{
    /** @throws QueryHandlerException */
    public function handle(Query $query): OptionalResult;
}
