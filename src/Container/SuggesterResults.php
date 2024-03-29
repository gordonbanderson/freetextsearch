<?php

declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Container;

class SuggesterResults
{
    /** @var string */
    private $index;

    /** @var string */
    private $query;

    /** @var array<string> */
    private $results = [];

    /** @var int */
    private $limit;


    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }


    public function getIndex(): string
    {
        return $this->index;
    }


    public function setLimit(int $newLimit): void
    {
        $this->limit = $newLimit;
    }


    public function getLimit(): int
    {
        return $this->limit;
    }


    public function setQuery(string $newQuery): void
    {
        $this->query = $newQuery;
    }


    public function getQuery(): string
    {
        return $this->query;
    }


    /** @return array<string> */
    public function getResults(): array
    {
        return $this->results;
    }


    /** @param array<string> $newResults */
    public function setResults(array $newResults): void
    {
        $this->results = $newResults;
    }
}
