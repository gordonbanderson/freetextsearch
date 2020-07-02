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

    private $facets;

    /** @var string */
    private $index;

    private $page;

    private $pageSize;

    /** @var string */
    private $query;

    /** @var ArrayList */
    private $records;



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


    public function getNumberOfResults()
    {
        return count($this->records);
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


    /**
     * @param ArrayList $newRecords
     */
    public function setRecords($newRecords)
    {
        $this->records = $newRecords;
    }



    public function setTime($newTime)
    {
        $this->time = $newTime;
    }
}
