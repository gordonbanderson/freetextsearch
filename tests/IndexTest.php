<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Index;

class IndexTest extends SapphireTest
{
    public function testSetGetName(): void
    {
        $index = new Index();
        $index->setName('testname');
        $this->assertEquals('testname', $index->getName());
    }

    public function testSetClass()
    {
        $index = new Index();
        $index->setClass('\Page');
        $this->assertEquals('\Page', $index->getClass());
    }

    public function testSetClassNull()
    {
        $index = new Index();
        $index->setClass(null);
        $this->assertNull($index->getClass());
    }

    public function testHasOneFields()
    {
        $index = new Index();
        $this->assertEquals([], $index->getHasOneFields());
        $index->addHasOneField('first');
        $this->assertEquals(['first'], $index->getHasOneFields());
        $index->addHasOneField('second');
        $this->assertEquals(['first', 'second'], $index->getHasOneFields());
        $index->addHasOneField('third');
        $this->assertEquals(['first', 'second', 'third'], $index->getHasOneFields());
        $index->addHasOneField('fourth');
        $this->assertEquals(['first', 'second', 'third', 'fourth'], $index->getHasOneFields());
    }

    public function testHasManyields()
    {
        $index = new Index();
        $this->assertEquals([], $index->getHasManyFields());
        $index->addHasManyField('first');
        $this->assertEquals(['first'], $index->getHasManyFields());
        $index->addHasManyField('second');
        $this->assertEquals(['first', 'second'], $index->getHasManyFields());
        $index->addHasManyField('third');
        $this->assertEquals(['first', 'second', 'third'], $index->getHasManyFields());
        $index->addHasManyField('fourth');
        $this->assertEquals(['first', 'second', 'third', 'fourth'], $index->getHasManyFields());
    }


    public function testAddTokens()
    {
        $index = new Index();
        $this->assertEquals([], $index->getTokens());
        $index->addToken('first');
        $this->assertEquals(['first'], $index->getTokens());
        $index->addToken('second');
        $this->assertEquals(['first', 'second'], $index->getTokens());
        $index->addToken('third');
        $this->assertEquals(['first', 'second', 'third'], $index->getTokens());
        $index->addToken('fourth');
        $this->assertEquals(['first', 'second', 'third', 'fourth'], $index->getTokens());
    }


    public function testAddFields()
    {
        $index = new Index();
        $this->assertEquals([], $index->getFields());
        $index->addField('first');
        $this->assertEquals(['first'], $index->getFields());
        $index->addField('second');
        $this->assertEquals(['first', 'second'], $index->getFields());
        $index->addField('third');
        $this->assertEquals(['first', 'second', 'third'], $index->getFields());
        $index->addField('fourth');
        $this->assertEquals(['first', 'second', 'third', 'fourth'], $index->getFields());
    }
}
