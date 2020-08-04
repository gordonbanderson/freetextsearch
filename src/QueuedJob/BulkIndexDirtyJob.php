<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\QueuedJob;

use Suilven\FreeTextSearch\Helper\BulkIndexingHelper;
use Symbiote\QueuedJobs\Services\AbstractQueuedJob;

class BulkIndexDirtyJob extends AbstractQueuedJob
{

    // variable $indexName cannot be declared here, because serialization of the job does not store this variable

    public function getTitle(): string
    {
        return 'Bulk Index Dirty DataObjects';
    }


    /** @param string $newIndexName the name of the index */
    public function hydrate(string $newIndexName): void
    {
        $this->indexName = $newIndexName;
    }


    public function setup(): void
    {
        $this->totalSteps = 1;
    }


    public function process(): void
    {
        $helper = new BulkIndexingHelper();
        $helper->bulkIndex($this->indexName, true);

        $this->isComplete = true;
    }
}
