<?php declare(strict_types = 1);

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

    private $query;


    /** @var array<string> */
    private $results;


    /** @var float the time in seconds */
    private $time;


    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
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
     * @param $newResults array<string>
     */
    public function setResults($newResults)
    {
        $this->results = $newResults;
    }


    public function setTime($newTime)
    {
        $this->time = $newTime;
    }
}
