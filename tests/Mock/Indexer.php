<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

use SilverStripe\ORM\DataObject;

class Indexer extends \Suilven\FreeTextSearch\Base\Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{

    public function index(DataObject $dataObject): void
    {
        // Do nothing, this is for testing
        \error_log('INDEXING ' . $dataObject->ID);
    }
}
