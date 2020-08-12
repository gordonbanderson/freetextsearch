<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use League\CLImate\CLImate;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Factory\BulkIndexerFactory;
use Suilven\FreeTextSearch\Helper\BulkIndexingHelper;
use Suilven\FreeTextSearch\Interfaces\BulkIndexer;
use Suilven\FreeTextSearch\QueuedJob\BulkIndexDirtyJob;
use Symbiote\QueuedJobs\DataObjects\QueuedJobDescriptor;
use Symbiote\QueuedJobs\Services\QueuedJob;

class BulkIndexerTest extends SapphireTest
{
    protected static $fixture_file = ['tests/fixtures/sitetree.yml'];

    public function setUp(): void
    {
        parent::setUp();

        $config = SiteConfig::current_site_config();
        $config->FreeTextSearchIndexingModeInBulk = 1;
        $config->write();
    }


    public function testSingleDocumentBeingQueuedForBulkIndexing(): void
    {
        $before = QueuedJobDescriptor::get()->count();

        $page = $this->objFromFixture(SiteTree::class, 'sitetree_10');
        $page->Title = 'This is a new title';
        $page->write();

        $after = QueuedJobDescriptor::get()->count();

        // assert that 1 job has been created, then inspect the contents
        $this->assertEquals(1, $after - $before);
        $jobDescriptor = QueuedJobDescriptor::get()->first();
        $this->assertEquals('Bulk Index Dirty DataObjects', $jobDescriptor->JobTitle);
        $this->assertEquals('O:8:"stdClass":1:{s:9:"indexName";s:8:"sitetree";}', $jobDescriptor->SavedJobData);

        // create the job class
        $impl = $jobDescriptor->Implementation;
        /** @var BulkIndexDirtyJob $job */
        $job = Injector::inst()->create($impl);

        // populate data - taken from QueuedJobService
        $jobData = null;
        $messages = null;

        // switching to php's serialize methods... not sure why this wasn't done from the start!
        $jobData = @unserialize($jobDescriptor->SavedJobData);
        $messages = @unserialize($jobDescriptor->SavedJobMessages);

        // try decoding as json if null
        $jobData = $jobData ?: json_decode($jobDescriptor->SavedJobData);
        $messages = $messages ?: json_decode($jobDescriptor->SavedJobMessages);

        $job->setJobData(
            $jobDescriptor->TotalSteps,
            $jobDescriptor->StepsProcessed,
            $jobDescriptor->JobStatus == QueuedJob::STATUS_COMPLETE,
            $jobData,
            $messages
        );

        $job->setup();
        $job->process();

        // @todo How to test assertions here?
        //$this->assertEquals(1, $job->totalSteps);
    }


    public function testBulkIndexAll()
    {
        $helper = new BulkIndexingHelper();
        $helper->bulkIndex('sitetree', false, new CLImate());
        // @todo assertions

    }


    public function tearDown(): void
    {
        parent::tearDown();

        $config = SiteConfig::current_site_config();
        $config->FreeTextSearchIndexingModeInBulk = 0;
        $config->write();
    }
}
