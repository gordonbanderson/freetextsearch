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
use Suilven\FreeTextSearch\Factory\IndexCreatorFactory;

class CreateIndexTask extends BuildTask
{

    protected $title = 'Create Index';

    protected $description = 'Create an index of a given name';

    protected $enabled = true;

    private static $segment = 'create-index';


    /**
     * Implement this method in the task subclass to
     * execute via the TaskRunner
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     * @param \Suilven\FreeTextSearch\Task\HTTPRequest $request
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

        $name = $request->getVar('index');
        $climate->info('NAME: ' . $name);

        $factory = new IndexCreatorFactory();
        $indexCreator = $factory->getIndexCreator();

        // @todo Does the index need dropped prior to re-creation?
        $indexCreator->createIndex($name);
    }
}
