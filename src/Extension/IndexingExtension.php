<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Extension;

use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Factory\IndexerFactory;
use Suilven\FreeTextSearch\QueuedJob\BulkIndexDirtyJob;
use Symbiote\QueuedJobs\Services\QueuedJobService;

/**
 * Class IndexingExtension
 *
 * @package Suilven\FreeTextSearch\Extension
 * @property bool $IsDirtyFreeTextSearch true if this DataObject needs reindexed
 */
class IndexingExtension extends DataExtension
{
    /** @var array<string,string> */
    private static $db= [
      'IsDirtyFreeTextSearch' => 'Boolean',
    ];


    public function onBeforeWrite(): void
    {
        parent::onBeforeWrite();

        $config = SiteConfig::current_site_config();

        // @phpstan-ignore-next-line
        if ($config->FreeTextSearchIndexingModeInBulk === 0) {
            return;
        }

        // @phpstan-ignore-next-line
        $this->owner->IsDirtyFreeTextSearch = true;
    }


    /**
     * @TODO this breaks on a virginal install
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function onAfterWrite(): void
    {
        parent::onAfterWrite();

        error_log('OAW ' . $this->getOwner()->ID);

        $config = SiteConfig::current_site_config();

        // @phpstan-ignore-next-line
        if ($config->FreeTextSearchIndexingModeInBulk === 1) {
            // Add a bulk index job to the queue.
            // Given same parameters, in this case index name, only one queued job is created
            // even if multiple documents saved in between cron jobs
            $job = new BulkIndexDirtyJob();
            // @todo update all relevant indexes
            $job->hydrate('sitetree');
            // @todo this breaks manticore search with a strange db error
            error_log("ADDING QJ");
            QueuedJobService::singleton()->queueJob($job);
        } else {
            // IsDirtyFreeTextSearch flag is not used sa we are indexing immediately
            $factory = new IndexerFactory();
            $indexer = $factory->getIndexer();

            $indexer->index($this->owner);
        }
    }
}
