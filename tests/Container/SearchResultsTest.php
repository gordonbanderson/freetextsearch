<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Container;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Container\SearchResults;

class SearchResultsTest extends SapphireTest
{
    public function testGetSetNumberOfResults(): void
    {
        $sr = new SearchResults();
        $sr->setTotalNumberOfResults(20);
        $this->assertEquals(20, $sr->getTotaNumberOfResults());
    }


    public function testGetRecordsNoResults(): void
    {
        $sr = new SearchResults();
        $records = $sr->getRecords();
        $this->assertEquals(0, $records->count());
    }
}
