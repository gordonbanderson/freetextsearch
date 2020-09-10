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
use Suilven\FreeTextSearch\Helper\IndexingHelper;
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


    /**
     * If we are bulk indexing mark the dataobject as dirty
     */
    public function onBeforeWrite(): void
    {
        parent::onBeforeWrite();

        $config = SiteConfig::current_site_config();

        // @phpstan-ignore-next-line
        if ($config->FreeTextSearchIndexingModeInBulk === 0) {
            return;
        }

        // @phpstan-ignore-next-line
        $this->getOwner()->IsDirtyFreeTextSearch = true;
    }


    /**
     * If bulk indexing, add a job to index dirty objects on the queue. Otherwise index immediately
     *
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function onAfterWrite(): void
    {
        parent::onAfterWrite();

        $config = SiteConfig::current_site_config();

        // a dataobject could belong to multiple indexes.  Update them all
        $helper = new IndexingHelper();

        // @phpstan-ignore-next-line
        $indexNames = $helper->getIndexes($this->getOwner());

        // @phpstan-ignore-next-line
        if ($config->FreeTextSearchIndexingModeInBulk === 1) {
            // Add a bulk index job to the queue.
            // Given same parameters, in this case index name, only one queued job is created
            // even if multiple documents saved in between cron jobs
            $job = new BulkIndexDirtyJob();

            foreach ($indexNames as $indexName) {
                $job->hydrate($indexName);
                QueuedJobService::singleton()->queueJob($job);
            }
        } else {
            // IsDirtyFreeTextSearch flag is not used sa we are indexing immediately
            $factory = new IndexerFactory();
            $indexer = $factory->getIndexer();
            foreach ($indexNames as $indexName) {
                $indexer->setIndexName($indexName);

                // @phpstan-ignore-next-line
                $indexer->index($this->getOwner());
            }
        }
    }
}
