<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use League\CLImate\CLImate;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\Queries\SQLUpdate;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Factory\BulkIndexerFactory;
use Suilven\FreeTextSearch\Indexes;

class BulkIndexingHelper
{
    /**
     * @param string $indexName
     * @param boolean $dirty Set this to true to only index 'dirty' DataObjects, false to reindex all
     * @param CLImate|null $climate
     */
    public function bulkIndex($indexName, $dirty = false, $climate = null)
    {
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);

        /** @var string $clazz */
        $clazz = $index->getClass();


        $startTime = \microtime(true);

        if (!(is_null($climate))) {
            $climate->border('*');
            $climate->green()->bold('Indexing sitetree');
            $climate->border();
        }

        $filters = ['ShowInSearch' => true];
        if ($dirty) {
            $filters['IsDirtyFreeTextSearch'] = true;
        }

        $nDocuments = SiteTree::get()->filter($filters)->count();

        if ($nDocuments > 0) {
            $config = SiteConfig::current_site_config();

            // * @phpstan-ignore-next-line
            $bulkSize = $config->BulkSize;
            $pages = 1+\round($nDocuments / $bulkSize);
            $progress = !is_null($climate) ? $climate->progress()->total($nDocuments) : null;

            if (is_null($climate)) {
                $climate->green('Pages: ' . $pages);
                $climate->green()->info('Indexing ' . $nDocuments .' objects');
            }

            $factory = new BulkIndexerFactory();
            $bulkIndexer = $factory->getBulkIndexer();
            $bulkIndexer->setIndex($indexName);

            for ($i = 0; $i < $pages; $i++) {
                $dataObjects = $clazz::get()->limit($bulkSize, $i*$bulkSize)->filter($filters);
                foreach ($dataObjects as $do) {
                    // @hack @todo FIX
                    if ($do->ID === 6) {
                        continue;
                    }

                    // Note this adds data to the payload, does not actually indexing against the third party search engine
                    $bulkIndexer->addDataObject($do);
                }

                // index objects up to configured bulk size
                $bulkIndexer->indexDataObjects();
                $current = $bulkSize * ($i+1);
                if ($current > $nDocuments) {
                    $current = $nDocuments;
                }
                if (!is_null($progress)) {
                    $progress->current($current);
                }
            }
        }


        $endTime = \microtime(true);
        $delta = $endTime-$startTime;

        $rate = \round($nDocuments / $delta, 2);

        $elapsedStr = \round($delta, 2);

        if (!is_null($climate)) {
            $climate->bold()->blue()->inline("{$nDocuments}");
            $climate->blue()->inline(' objects indexed in ');
            $climate->bold()->blue()->inline("{$elapsedStr}");
            $climate->blue()->inline('s, ');
            $climate->bold()->blue()->inline("{$rate}");
            $climate->blue(' per second ');
        }

        $clazz = $index->getClass();
        $table =     Config::inst()->get($clazz, 'table_name');


        DB::query("UPDATE \"{$table}\" SET \"IsDirtyFreeTextSearch\" = 0");

        // @todo How to get the table name from versions?
        DB::query("UPDATE \"{$table}_Live\" SET \"IsDirtyFreeTextSearch\" = 0");


    }
}
