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
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Versioned\Versioned;
use Suilven\FreeTextSearch\Factory\BulkIndexerFactory;
use Suilven\FreeTextSearch\Indexes;

class BulkIndexingHelper
{
    /**
     * Bulk index all or just the 'dirty' items
     *
     * @param bool $dirty Set this to true to only index 'dirty' DataObjects, false to reindex all
     * @return int the number of documents indexed
     */
    public function bulkIndex(string $indexName, bool $dirty = false, ?CLImate $climate = null): int
    {
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);

        /** @var string $clazz */
        $clazz = $index->getClass();

        /** @var DataObject $singleton */
        $singleton = \singleton($clazz);

        $startTime = \microtime(true);

        if (!(\is_null($climate))) {
            $climate->border('*');
            $climate->green()->bold('Indexing sitetree');
            $climate->border();
        }

        // @TODO this needs applied when appropriate, doesn't work with for example random dataobjects outside of
        // the sitetree paradigm
        //$filters = ['ShowInSearch' => true];

        $filters = [];
        if ($dirty) {
            $filters['IsDirtyFreeTextSearch'] = true;
        }

        $nDocuments = $singleton::get()->filter($filters)->count();

        if ($nDocuments > 0) {
            $config = SiteConfig::current_site_config();

            // * @phpstan-ignore-next-line
            $bulkSize = $config->BulkSize;

            $pages = 1+\round($nDocuments / $bulkSize);
            $progress = !\is_null($climate)
                ? $climate->progress()->total($nDocuments)
                : null;

            if (!\is_null($climate)) {
                $climate->green('Pages: ' . $pages);
                $climate->green()->info('Indexing ' . $nDocuments .' objects');
            }

            $factory = new BulkIndexerFactory();
            $bulkIndexer = $factory->getBulkIndexer();
            $bulkIndexer->setIndex($indexName);

            for ($i = 0; $i < $pages; $i++) {
                $dataObjects = $clazz::get()->limit($bulkSize, $i*$bulkSize)->filter($filters);
                foreach ($dataObjects as $do) {
                    // Note this adds data to the payload, doesn't actually indexing against the 3rd party search engine
                    $bulkIndexer->addDataObject($do);
                }

                // index objects up to configured bulk size
                $bulkIndexer->indexDataObjects();
                $current = $bulkSize * ($i+1);
                if ($current > $nDocuments) {
                    $current = $nDocuments;
                }
                if (\is_null($progress)) {
                    continue;
                }

                $progress->current($current);
            }
        }


        $endTime = \microtime(true);
        $delta = $endTime-$startTime;

        $rate = \round($nDocuments / $delta, 2);

        $elapsedStr = \round($delta, 2);

        if (!\is_null($climate)) {
            $climate->bold()->blue()->inline("{$nDocuments}");
            $climate->blue()->inline(' objects indexed in ');
            $climate->bold()->blue()->inline("{$elapsedStr}");
            $climate->blue()->inline('s, ');
            $climate->bold()->blue()->inline("{$rate}");
            $climate->blue(' per second ');
        }

        $clazz = $index->getClass();
        $table = Config::inst()->get($clazz, 'table_name');


        if ($singleton->hasExtension(Versioned::class)) {
            DB::query("UPDATE \"{$table}_Live\" SET \"IsDirtyFreeTextSearch\" = 0");
        }

        DB::query("UPDATE \"{$table}\" SET \"IsDirtyFreeTextSearch\" = 0");

        return $nDocuments;
    }
}
