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


    public function testSetClass(): void
    {
        $index = new Index();
        $index->setClass('\Page');
        $this->assertEquals('\Page', $index->getClass());
    }


    public function testSetClassNull(): void
    {
        $index = new Index();
        $index->setClass(null);
        $this->assertNull($index->getClass());
    }


    public function testHasOneFields(): void
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


    public function testHasManyields(): void
    {
        $payload = [
            'name' => 'tags',
            'relationship' => 'FlickrTags',
            'field' => 'RawValue',
        ];
        $index = new Index();
        $this->assertEquals([], $index->getHasManyFields());
        $index->addHasManyField('first', $payload);
        $this->assertEquals(['first' => $payload], $index->getHasManyFields());
        $index->addHasManyField('second', $payload);
        $this->assertEquals(['first' => $payload, 'second' => $payload], $index->getHasManyFields());
        $index->addHasManyField('third', $payload);
        $this->assertEquals(
            ['first' => $payload, 'second' => $payload, 'third' => $payload],
            $index->getHasManyFields()
        );
        $index->addHasManyField('fourth', $payload);
        $this->assertEquals(
            ['first' => $payload, 'second' => $payload, 'third' => $payload, 'fourth' => $payload],
            $index->getHasManyFields()
        );
    }


    public function testAddTokens(): void
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


    public function testAddFields(): void
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
