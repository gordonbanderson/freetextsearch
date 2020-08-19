<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Task;

use League\CLImate\CLImate;
use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use Suilven\FreeTextSearch\Helper\BulkIndexingHelper;

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

        // for testing purposes
        $fail = $request->getVar('fail');
        if (!\is_null($fail)) {
            $canAccess = false;
        }

        if (!$canAccess) {
            return Security::permissionFailure(null, 'Permission denied');
        }


        /** @var string $indexName */
        $indexName = $request->getVar('index');

        $helper = new BulkIndexingHelper();
        $helper->bulkIndex($indexName, false, $climate);
    }
}
