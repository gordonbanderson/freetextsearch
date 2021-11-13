<?php

declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Base;

use Suilven\FreeTextSearch\Container\SearchResults;
use Suilven\FreeTextSearch\Types\SearchParamTypes;

abstract class Searcher implements \Suilven\FreeTextSearch\Interfaces\Searcher
{
    /** @var array<string,string|int|float|bool> $filters */
    protected $filters = [];

    /** @var int */
    protected $pageSize = 15;

    /** @var int */
    protected $page = 1;

    /** @var string */
    protected $indexName;

    /** @var array<string,string> */
    protected $facettedTokens = [];

    /** @var array<string> */
    protected $hasManyTokens = [];

    /** @var string */
    protected $searchType = SearchParamTypes::AND;


    abstract public function search(?string $q): SearchResults;


    /** @param array<string,string|int|float|bool> $filters */
    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }


    public function setPageSize(int $pageSize): void
    {
        $this->pageSize = $pageSize;
    }


    public function setIndexName(string $indexName): void
    {
        $this->indexName = $indexName;
    }



    /** @param array<string,string> $facettedTokens */

    public function setFacettedTokens(array $facettedTokens): void
    {
        $this->facettedTokens = $facettedTokens;
    }


    /** @param array<string> $hasManyTokens */
    public function setHasManyTokens(array $hasManyTokens): void
    {
        $this->hasManyTokens = $hasManyTokens;
    }


    public function setPage(int $pageNumber): void
    {
        $this->page = $pageNumber;
    }


    public function setSearchType(string $newSearchType): void
    {
        $this->searchType = $newSearchType;
    }
}
