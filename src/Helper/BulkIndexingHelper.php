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
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Factory\BulkIndexerFactory;
use Suilven\FreeTextSearch\Indexes;

class BulkIndexingHelper
{
    /**
     * @param $indexName
     * @param CLImate|null $climate
     */
    public function bulkIndex($indexName, $climate = null)
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


        $nDocuments = SiteTree::get()->count();
        $config = SiteConfig::current_site_config();

        // * @phpstan-ignore-next-line
        $bulkSize = $config->BulkSize;
        $pages = 1+\round($nDocuments / $bulkSize);
        $progress = !is_null($climate) ? $climate->progress()->total($nDocuments) : null;

        if (is_null($climate)) {
            $climate->green('Pages: ' . $pages);
            $climate->green()->info('Indexing ' . $nDocuments .' objects');
        }

        $climate->orange("Preparing bulk indexer");
        $factory = new BulkIndexerFactory();
        $bulkIndexer = $factory->getBulkIndexer();
        $bulkIndexer->setIndex($indexName);

        for ($i = 0; $i < $pages; $i++) {
            $dataObjects = $clazz::get()->limit($bulkSize, $i*$bulkSize)->filter('ShowInSearch', true);
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

    }
}
