<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Container;

use SilverStripe\ORM\ArrayList;

/**
 * Class SearchResults
 *
 * Store the search results in a manner that is renderable in a SilverStripe template
 *
 * @package Suilven\FreeTextSearch\Container
 */
class SearchResults
{

    /** @var array<string,int|bool|float|string> */
    private $facets;

    /** @var string */
    private $index;

    /** @var int */
    private $page;

    /** @var int */
    private $pageSize;

    /** @var string */
    private $query;

    /** @var \SilverStripe\ORM\ArrayList */
    private $records;

    /** @var array<string> */
    private $suggestions;

    /** @var float the time in seconds */
    private $time;

    public function __construct()
    {
        $this->time = 0;
        $this->suggestions =[];
    }


    /** @param array<string,int|bool|float|string> $newFacets */
    public function setFacets(array $newFacets): void
    {
        $this->facets = $newFacets;
    }


    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }


    public function getNumberOfResults(): int
    {
        return \count($this->records);
    }


    public function getPage(): int
    {
        return $this->page;
    }


    public function setPage(int $newPage): void
    {
        $this->page = $newPage;
    }


    public function getPageSize(): int
    {
        return $this->pageSize;
    }


    public function setPageSize(int $newPageSize): void
    {
        $this->pageSize = $newPageSize;
    }


    public function getQuery(): string
    {
        return $this->query;
    }


    public function setQuery(string $newQuery): void
    {
        $this->query = $newQuery;
    }


    public function setRecords(ArrayList $newRecords): void
    {
        $this->records = $newRecords;
    }


    public function getRecords(): \SilverStripe\ORM\ArrayList
    {
        return $this->records;
    }


    /** Accessor to the suggestions
     *
     * @return array<string>
     */
    public function getSuggestions(): array
    {
        return $this->suggestions;
    }


    /** @param array<string> $newSuggestions */
    public function setSuggestions(array $newSuggestions): void
    {
        $this->suggestions = $newSuggestions;
    }


    public function getTime(): float
    {
        return $this->time;
    }


    public function setTime(float $newTime): void
    {
        $this->time = $newTime;
    }
}
