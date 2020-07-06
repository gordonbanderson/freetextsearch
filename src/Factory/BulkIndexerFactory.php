<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Factory;

use SilverStripe\Core\Injector\Injector;
use Suilven\FreeTextSearch\Interfaces\BulkIndexer;
use Suilven\FreeTextSearch\Interfaces\Indexer;

class BulkIndexerFactory
{
    public function getBulkIndexer(): BulkIndexer
    {
        return Injector::inst()->get('FreeTextBulkIndexerImplementation');
    }
}
