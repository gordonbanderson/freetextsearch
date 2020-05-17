<?php
namespace Suilven\FreeTextSearch\Tests;

use Suilven\FreeTextSearch\Index;

class IndexTest
{
    public function testSetGetName()
    {
        $index = new Index();
        $index->setName('testname');
        $this->assertEquals('testname', $index->getName());
    }
}
