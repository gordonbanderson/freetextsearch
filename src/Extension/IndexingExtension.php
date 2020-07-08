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
        //parent::onBeforeWrite();

        error_log('++++ IE obw ' . $this->owner->ID);

        $config = SiteConfig::current_site_config();

        error_log('Checking for non bulk');
        // @phpstan-ignore-next-line
        if ($config->FreeTextSearchIndexingModeInBulk === false) {
            error_log('Non bulk');
            return;
        }

        error_log('Setting IsDirtyFreeTextSearch to true for bulk indexing');
        // @phpstan-ignore-next-line
        $this->owner->IsDirtyFreeTextSearch = true;

        // this works
        // $this->owner->Content = 'Content from OBW';
    }


    public function onAfterWriteNOT(): void
    {
        // @phpstan-ignore-next-line
       // $this->owner->onAfterWrite();

        error_log('++++ IE oaw' . $this->owner->ID);


        $config = SiteConfig::current_site_config();

        // defer indexing to bulk
        // @phpstan-ignore-next-line
        if ($config->FreeTextSearchIndexingModeInBulk === true) {
            return;
        }

        // IsDirtyFreeTextSearch flag is not used sa we are indexing immediately
        $factory = new IndexerFactory();
        $indexer = $factory->getIndexer();

        $indexer->index($this->owner);
    }
}
