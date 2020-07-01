<?php declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Task;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;
use Suilven\FreeTextSearch\Factory\IndexCreatorFactory;
use Suilven\FreeTextSearch\Indexes;


class CreateIndexTask extends BuildTask
{

    protected $title = 'Create Index';

    protected $description = 'Create an index of a given name';

    private static $segment = 'create-index';

    protected $enabled = true;

    public function run($request)
    {
        // check this script is being run by admin
        $canAccess = (Director::isDev() || Director::is_cli() || Permission::check("ADMIN"));
        if (!$canAccess) {
            return Security::permissionFailure($this);
        }

        $name = isset($_GET['name']) ? $_GET['name'] : 'all';

        $factory = new IndexCreatorFactory();
        $indexCreator = $factory->getIndexCreator();
        $indexCreator->createIndex($name);


    }

}
