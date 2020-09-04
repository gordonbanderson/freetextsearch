<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Extension;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\DB;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Tests\Mock\Indexer;
use Suilven\FreeTextSearch\Tests\Models\FlickrPhoto;
use Suilven\FreeTextSearch\Tests\Models\FlickrTag;
use Symbiote\QueuedJobs\DataObjects\QueuedJobDescriptor;

class IndexingExtensionTest extends SapphireTest
{

    protected static $extra_dataobjects = [
        FlickrPhoto::class,
        FlickrTag::class,
    ];

    // this will enable immediate indexing
    public function setUp(): void
    {
        parent::setUp();

        $config = SiteConfig::current_site_config();
        $config->FreeTextSearchIndexingModeInBulk = 0;
        $config->write();
    }


    public function testIndividualPage(): void
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


    // same as the previous test, but against a different index - it was previously hardcoded
    public function testIndividualPhoto(): void
    {
        Indexer::resetIndexedPayload();

        // only one job is created per index when there are dirty objects to index.  This is dealt with within the
        // queued jobs module, in that the job parameters are identical.  One job will already be present from
        // loading of the fixtures.  As such, clear the queue
        DB::query('DELETE FROM "QueuedJobDescriptor"');

        $this->assertEquals(0, QueuedJobDescriptor::get()->count());

        $photo = new FlickrPhoto();
        $photo->Title = 'Rupert liked playing chess';
        $photo->Description = '<p>THe black queen had been taken</p>';
        $photo->write();

        $this->assertEquals(0, QueuedJobDescriptor::get()->count());

        $payload = Indexer::getIndexedPayload();
        $this->assertEquals(1, \sizeof($payload));
        $firstPagePayload = $payload[0];
        $this->assertEquals([], $firstPagePayload['sitetree']);
        $this->assertEquals([], $firstPagePayload['members']);
        $this->assertEquals('Rupert liked playing chess', $firstPagePayload['flickrphotos']['Title']);
        $this->assertEquals('<p>THe black queen had been taken</p>', $firstPagePayload['flickrphotos']['Description']);
    }


    // same as the previous test, but against a different index - it was previously hardcoded
    public function testIndividualMember(): void
    {
        Indexer::resetIndexedPayload();

        // only one job is created per index when there are dirty objects to index.  This is dealt with within the
        // queued jobs module, in that the job parameters are identical.  One job will already be present from
        // loading of the fixtures.  As such, clear the queue
        DB::query('DELETE FROM "QueuedJobDescriptor"');

        $this->assertEquals(0, QueuedJobDescriptor::get()->count());

        $member = new Member();
        $member->FirstName = 'Gordon';
        $member->Surname = 'Anderson';
        $member->Email = 'gba01@mailinator.com';
        $member->write();

        $this->assertEquals(0, QueuedJobDescriptor::get()->count());

        $payload = Indexer::getIndexedPayload();
        $this->assertEquals(1, \sizeof($payload));
        $firstPagePayload = $payload[0];
        $this->assertEquals([], $firstPagePayload['sitetree']);
        $this->assertEquals([], $firstPagePayload['flickrphotos']);
        $this->assertEquals('Gordon', $firstPagePayload['members']['FirstName']);
        $this->assertEquals('Anderson', $firstPagePayload['members']['Surname']);
        $this->assertEquals('gba01@mailinator.com', $firstPagePayload['members']['Email']);
    }


    public function tearDown(): void
    {
        parent::tearDown();

        $config = SiteConfig::current_site_config();
        $config->FreeTextSearchIndexingModeInBulk = 1;
        $config->write();
    }
}
