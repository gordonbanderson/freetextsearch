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
        // * @phpstan-ignore-next-line
        if ($config->FreeTextSearchIndexingModeInBulk !== true) {
            return;
        }

        // @phpstan-ignore-next-line
        $this->owner->IsDirtyFreeTextSearch = true;
    }


    public function onAfterWrite(): void
    {
        // @phpstan-ignore-next-line
        $this->owner->onAfterWrite();

        $config = SiteConfig::current_site_config();

        // @phpstan-ignore-next-line
        if ($config->FreeTextSearchIndexingModeInBulk !== false) {
            return;
        }

        $factory = new IndexerFactory();
        $indexer = $factory->getIndexer();

        $indexer->index($this->owner);

        // @phpstan-ignore-next-line
        $this->owner->IsDirtyFreeTextSearch = false;
        $this->owner->write();
    }
}
