<?php
namespace Suilven\FreeTextSearch\Tests;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\CMS\Model\SiteTree;
use Suilven\FreeTextSearch\Index;
use Suilven\FreeTextSearch\Indexes;

class IndexesTest extends SapphireTest
{
    public function testGetIndexes()
    {
        $indexes = new Indexes();
        $actualIndexes = $indexes->getIndexes();
        error_log(print_r($actualIndexes, 1));
    }
}
