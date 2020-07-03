<?php declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Extension;

use SilverStripe\Core\Extension;
use Suilven\FreeTextSearch\Factory\IndexerFactory;
use Suilven\FreeTextSearch\Index;

class IndexingExtension extends Extension
{

    public function onAfterWrite()
    {
        $this->owner->onAfterWrite();


        $factory = new IndexerFactory();
        $indexer = $factory->getIndexer();

        $indexer->index($this->owner);

    }
}
