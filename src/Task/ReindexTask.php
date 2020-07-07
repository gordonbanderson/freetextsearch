<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Task;

use League\CLImate\CLImate;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use Suilven\FreeTextSearch\Factory\BulkIndexerFactory;
use Suilven\FreeTextSearch\Indexes;

class ReindexTask extends BuildTask
{

    protected $title = 'Reindex';

    protected $description = 'Reindex all dataobjects referred to in indexes';

    protected $enabled = true;

    /** @var string */
    private static $segment = 'reindex';

    /**
     * Implement this method in the task subclass to
     * execute via the TaskRunner
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     * @param \SilverStripe\Control\HTTPRequest $request
     * @return \SilverStripe\Control\HTTPResponse|void
     */
    public function run($request)
    {
        $climate = new CLImate();

        // check this script is being run by admin
        $canAccess = (Director::isDev() || Director::is_cli() || Permission::check("ADMIN"));
        if (!$canAccess) {
            return Security::permissionFailure(null);
        }


        /** @var string $indexName */
        $indexName = $request->getVar('index');
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);

        /** @var string $clazz */
        $clazz = $index->getClass();


        $startTime = \microtime(true);

        $climate->border();
        $climate->green()->bold('Indexing sitetree');
        $climate->border();

        $nDocuments = SiteTree::get()->count();
        $config = SiteConfig::current_site_config();

        // * @phpstan-ignore-next-line
        $bulkSize = $config->BulkSize;
        $pages = 1+\round($nDocuments / $bulkSize);
        $climate->green('Pages: ' . $pages);
        $climate->green()->info('Indexing ' . $nDocuments .' objects');
        $progress = $climate->progress()->total($nDocuments);

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

                $bulkIndexer->addDataObject($do);
            }
            $bulkIndexer->indexDataObjects();
            $current = $bulkSize * ($i+1);
            if ($current > $nDocuments) {
                $current = $nDocuments;
            }
            $progress->current($current);
        }



        $endTime = \microtime(true);
        $delta = $endTime-$startTime;

        $rate = \round($nDocuments / $delta, 2);

        $elapsedStr = \round($delta, 2);

        $climate->bold()->blue()->inline("{$nDocuments}");
        $climate->blue()->inline(' objects indexed in ');
        $climate->bold()->blue()->inline("{$elapsedStr}");
        $climate->blue()->inline('s, ');
        $climate->bold()->blue()->inline("{$rate}");
        $climate->blue(' per second ');
    }
}
