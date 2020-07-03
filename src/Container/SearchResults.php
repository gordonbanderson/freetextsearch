<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Container;

/**
 * Class SearchResults
 *
 * Store the search results in a manner that is renderable in a SilverStripe template
 *
 * @package Suilven\FreeTextSearch\Container
 */
class SearchResults
{

    private $facets;

    /** @var string */
    private $index;

    private $page;

    private $pageSize;

    /** @var string */
    private $query;

    /** @var \SilverStripe\ORM\ArrayList */
    private $records;

    /** @var float the time in seconds */
    private $time;



    public function setFacets($newFacets): void
    {
        $this->facets = $newFacets;
    }


    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }


    public function getFred()
    {
        return 'FRED****';
    }


    public function getNumberOfResults()
    {
        return \count($this->records);
    }


    public function getPage()
    {
        return $this->page;
    }


    public function setPage($newPage): void
    {
        $this->page = $newPage;
    }


    public function getPageSize()
    {
        return $this->pageSize;
    }


    public function setPageSize($newPageSize): void
    {
        $this->pageSize = $newPageSize;
    }


    public function getQuery()
    {
        return $this->query;
    }


    public function setQuery($newQuery): void
    {
        $this->query = $newQuery;
    }


    public function setRecords(ArrayList $newRecords): void
    {
        $this->records = $newRecords;
    }


    public function getRecords()
    {
        return $this->records;
    }


    public function getTime()
    {
        return $this->time;
    }


    public function setTime($newTime): void
    {
        $this->time = $newTime;
    }
}
