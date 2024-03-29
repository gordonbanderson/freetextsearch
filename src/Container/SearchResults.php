<?php

declare(strict_types = 1);

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

    /** @var array<\Suilven\FreeTextSearch\Container\Facet> */
    private $facets = [];

    /** @var string */
    private $indexName;

    /** @var int the total number of results */
    private $totalNumberOfResults = 0;

    /** @var int */
    private $page = 0;

    /** @var int */
    private $pageSize = 20;

    /** @var string */
    private $query = '';

    /** @var \SilverStripe\ORM\ArrayList|null */
    private $records;

    /** @var array<string> */
    private $suggestions;

    /** @var float the time in seconds */
    private $time;

    /** @var \SilverStripe\ORM\DataObject|null */
    private $searchSimilarTo = null;

    public function __construct()
    {
        $this->time = 0;
        $this->suggestions =[];
    }


    public function addFacet(Facet $facet): void
    {
        $this->facets[] = $facet;
    }


    public function setIndexName(string $newIndex): void
    {
        $this->indexName = $newIndex;
    }


    public function getIndexName(): string
    {
        return $this->indexName;
    }


    public function getTotaNumberOfResults(): int
    {
        return $this->totalNumberOfResults;
    }


    public function setTotalNumberOfResults(int $newTotalNumberOfResults): void
    {
        $this->totalNumberOfResults = $newTotalNumberOfResults;
    }


    public function getTotalPages(): int
    {
        $nPages = \ceil($this->totalNumberOfResults / $this->pageSize);

        return \intval($nPages);
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


    /** @return array<\Suilven\FreeTextSearch\Container\Facet> */
    public function getFacets(): array
    {
        return $this->facets ;
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
        return \is_null($this->records)
            ? new ArrayList([])
            : $this->records;
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


    public function getSimilarTo(): ?\SilverStripe\ORM\DataObject
    {
        return $this->searchSimilarTo;
    }


    public function setSimilarTo(?\SilverStripe\ORM\DataObject $dataObject): void
    {
        $this->searchSimilarTo = $dataObject;
    }
}
