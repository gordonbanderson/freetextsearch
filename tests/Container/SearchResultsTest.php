<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Container;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\DB;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Container\SearchResults;
use Suilven\FreeTextSearch\Tests\Mock\Indexer;
use Suilven\FreeTextSearch\Tests\Models\FlickrPhoto;
use Suilven\FreeTextSearch\Tests\Models\FlickrTag;
use Symbiote\QueuedJobs\DataObjects\QueuedJobDescriptor;

class SearchResultsTest extends SapphireTest
{
    public function testGetSetNumberOfResults()
    {
        $sr = new SearchResults();
        $sr->setTotalNumberOfResults(20);
        $this->assertEquals(20, $sr->getTotaNumberOfResults());
    }

    public function testGetRecordsNoResults()
    {
        $sr = new SearchResults();
        $records = $sr->getRecords();
        $this->assertEquals(0, $records->count());
    }
}
