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
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\BuildTask;
use Suilven\FreeTextSearch\Indexes;

class ReindexTask extends BuildTask
{

    protected $title = 'Reindex';

    protected $description = 'Reindex all dataobjects referred to in indexes';

    protected $enabled = true;

    private static $segment = 'reindex';

    /**
     * Implement this method in the task subclass to
     * execute via the TaskRunner
     *
     * @param HTTPRequest $request
     * @return
     */
    public function run($request)
    {
        $climate = new CLImate();

        // check this script is being run by admin
        $canAccess = (Director::isDev() || Director::is_cli() || Permission::check("ADMIN"));
        if (!$canAccess) {
            return Security::permissionFailure($this);
        }

        /** @var string $indexName */
        $indexName = $request->getVar('index');
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);
        $clazz = $index->getClass();


        $startTime = microtime(true);

        $climate->border();
        $climate->green()->bold('Indexing sitetree');
        $climate->border();

        $nDocuments = SiteTree::get()->count();
        $climate->green()->info('Indexing ' . $nDocuments .' objects');
        $progress = $climate->progress()->total($nDocuments);

        $ctr = 0;
        foreach ($clazz::get() as $do) {
            $do->write();

            $ctr++;
            $progress->current($ctr);
        }

        $endTime = microtime(true);
        $delta = $endTime-$startTime;

        $rate = round($delta / $nDocuments, 2);

        $elapsedStr = round($delta, 2);

        $climate->bold()->blue()->inline("{$nDocuments}");
        $climate->blue()->inline(' objects indexed in ');
        $climate->bold()->blue()->inline("{$elapsedStr}");
        $climate->blue()->inline('s, ');
        $climate->bold()->blue()->inline("{$rate}");
        $climate->blue()->inline(' per second ');

    }
}
