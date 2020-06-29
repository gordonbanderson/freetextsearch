<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Base;

use Suilven\FreeTextSearch\Interfaces\Searcher;

abstract class SearcherBase implements Searcher
{
    /** @var array<string,string|int|float> $filters */
    private $filters;

    /** @var int */
    private $pageSize;

    /** @var int */
    private $page;

    /** @var string */
    private $indexName;

    /** @var array<string,string> */
    private $facettedTokens;

    /** @var array<string> */
    private $hasManyTokens;

    /** @return array<string,array<string,string>> */
    abstract public function search(string $q): array;


    /** @param array<string,string|int|float> $filters */
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
}
