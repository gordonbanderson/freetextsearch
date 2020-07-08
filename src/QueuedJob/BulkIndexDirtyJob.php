<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\QueuedJob;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;
use Suilven\FreeTextSearch\Indexes;
use Symbiote\QueuedJobs\Services\AbstractQueuedJob;

class BulkIndexDirtyJob extends AbstractQueuedJob
{

    public function getTitle()
    {
        return 'Bulk Index Dirty DataObjects';
    }

    public function process()
    {
        // TODO: Implement process() method.
    }
}
