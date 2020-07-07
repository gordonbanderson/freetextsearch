<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Factory\IndexerFactory;

class IndexingExtension extends DataExtension
{
    private static $db= [
      'IsDirtyFreeTextSearch' => 'Boolean'
    ];


    public function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $config = SiteConfig::current_site_config();
        if ($config->FreeTextSearchIndexingModeInBulk === true) {
            $this->owner->IsDirtyFreeTextSearch = true;
        }

    }

    public function onAfterWrite(): void
    {
        $this->owner->onAfterWrite();

        $config = SiteConfig::current_site_config();
        if ($config->FreeTextSearchIndexingModeInBulk === false) {
            $factory = new IndexerFactory();
            $indexer = $factory->getIndexer();

            $indexer->index($this->owner);
            $this->owner->IsDirtyFreeTextSearch = false;
            $this->owner->write();
        }
    }
}
