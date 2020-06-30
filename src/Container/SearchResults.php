<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Container;

class SearchResults
{

    private $facets;

    /** @var string */
    private $index;

    private $page;

    private $pageSize;

    private string $query;

    private $results;


    /** @var float the time in seconds */
    private $time;



    public function setFacets($newFacets)
    {
        $this->facets = $newFacets;
    }

    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }

    public function setPage($newPage)
    {
        $this->page = $newPage;
    }

    public function setPageSize($newPage)
    {
        $this->page = $newPage;
    }

    public function setQuery($newQuery)
    {
        $this->query = $newQuery;
    }


    public function setResults($newResults)
    {
        $this->results = $newResults;
    }


    public function setTime($newTime)
    {
        $this->time = $newTime;
    }
}
