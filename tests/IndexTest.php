<?php
namespace Suilven\FreeTextSearch\Tests;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Index;

class IndexTest extends SapphireTest
{
    public function testSetGetName()
    {
        $index = new Index();
        $index->setName('testname');
        $this->assertEquals('testname', $index->getName());
    }
}
