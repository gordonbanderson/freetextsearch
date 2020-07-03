<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Task;

use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;
use Suilven\FreeTextSearch\Factory\IndexCreatorFactory;

class CreateIndexTask extends BuildTask
{

    protected $title = 'Create Index';

    protected $description = 'Create an index of a given name';

    protected $enabled = true;

    private static $segment = 'create-index';

    public function run($request)
    {
        // check this script is being run by admin
        $canAccess = (Director::isDev() || Director::is_cli() || Permission::check("ADMIN"));
        if (!$canAccess) {
            return Security::permissionFailure($this);
        }

        $name = isset($_GET['name'])
            ? $_GET['name']
            : 'all';

        $factory = new IndexCreatorFactory();
        $indexCreator = $factory->getIndexCreator();

        // @todo Does the index need dropped prior to re-creation?
        $indexCreator->createIndex($name);
    }
}
