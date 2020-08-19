<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Extension;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\DB;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Tests\Mock\Indexer;
use Symbiote\QueuedJobs\DataObjects\QueuedJobDescriptor;

class IndexingExtensionTest extends SapphireTest
{
    // this will enable immediate indexing
    public function setUp(): void
    {
        parent::setUp();

        $config = SiteConfig::current_site_config();
        $config->FreeTextSearchIndexingModeInBulk = 0;
        $config->write();
    }


    public function testIndividualDocument(): void
    {
        Indexer::resetIndexedPayload();

        // only one job is created per index when there are dirty objects to index.  This is dealt with within the
        // queued jobs module, in that the job parameters are identical.  One job will already be present from
        // loading of the fixtures.  As such, clear the queue
        DB::query('DELETE FROM "QueuedJobDescriptor"');

        $this->assertEquals(0, QueuedJobDescriptor::get()->count());

        $page = new \Page();
        $page->Title = 'Rupert liked playing chess';
        $page->Content = '<p>THe black queen had been taken</p>';
        $page->write();

        $this->assertEquals(0, QueuedJobDescriptor::get()->count());

        $payload = Indexer::getIndexedPayload();
        $this->assertEquals(1, \sizeof($payload));
        $firstPagePayload = $payload[0];
        $this->assertEquals([], $firstPagePayload['flickrphotos']);
        $this->assertEquals([], $firstPagePayload['members']);
        $this->assertEquals('Rupert liked playing chess', $firstPagePayload['sitetree']['Title']);
        $this->assertEquals('Rupert liked playing chess', $firstPagePayload['sitetree']['MenuTitle']);
        $this->assertEquals('<p>THe black queen had been taken</p>', $firstPagePayload['sitetree']['Content']);
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $config = SiteConfig::current_site_config();
        $config->FreeTextSearchIndexingModeInBulk = 1;
        $config->write();
    }
}
