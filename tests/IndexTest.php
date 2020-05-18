<?php
namespace Suilven\FreeTextSearch\Tests;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\CMS\Model\SiteTree;
use Suilven\FreeTextSearch\Index;

class IndexTest extends SapphireTest
{
    public function testSetGetName()
    {
        $index = new Index();
        $index->setName('testname');
        $this->assertEquals('testname', $index->getName());
    }

    public function testSetGetClass()
    {
        $index = new Index();
        $index->setClass('SilverStripe\CMS\Model\SiteTree');
        $this->assertEquals('SilverStripe\CMS\Model\SiteTree', $index->getClass());
    }

    public function testFields()
    {
        $index = new Index();
        $index->addField('field1');
        $index->addField('field2');
        $index->addField('field3');
        $this->assertEquals(['field1', 'field2', 'field3'], $index->getFields());
    }

    public function testHasOneFields()
    {
        $index = new Index();
        $index->addHasOneField('field1');
        $index->addHasOneField('field2');
        $index->addHasOneField('field3');
        $this->assertEquals(['field1', 'field2', 'field3'], $index->getHasOneFields());
    }

    public function testHasManyFields()
    {
        $index = new Index();
        $index->addHasManyField('field1');
        $index->addHasManyField('field2');
        $index->addHasManyField('field3');
        $this->assertEquals(['field1', 'field2', 'field3'], $index->getHasManyFields());
    }

    public function testTokens()
    {
        $index = new Index();
        $index->addToken('token1');
        $index->addToken('token2');
        $index->addToken('token3');
        $this->assertEquals(['token1', 'token2', 'token3'], $index->getTokens());
    }
}
