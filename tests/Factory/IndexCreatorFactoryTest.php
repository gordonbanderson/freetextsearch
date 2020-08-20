<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\IndexCreatorFactory;
use Suilven\FreeTextSearch\Tests\Mock\IndexCreator;

class IndexCreatorFactoryTest extends SapphireTest
{
    protected static $fixture_file = ['tests/fixtures/sitetree.yml'];

    public function testFactory(): void
    {
        $factory = new IndexCreatorFactory();

        /** @var \Suilven\FreeTextSearch\Tests\Mock\IndexCreator $indexCreator */
        $indexCreator = $factory->getIndexCreator();
        $this->assertInstanceOf('Suilven\FreeTextSearch\Interfaces\IndexCreator', $indexCreator);
        $this->assertInstanceOf('Suilven\FreeTextSearch\Tests\Mock\IndexCreator', $indexCreator);

        $indexCreator->createIndex('sitetree');

        $this->assertEquals('sitetree', IndexCreator::getIndexName());

        $reflection = new \ReflectionClass(\get_class($indexCreator));
        $method = $reflection->getMethod('getFieldSpecs');
        $method->setAccessible(true);

        $specs = $method->invokeArgs($indexCreator, ['sitetree']);
        $this->assertEquals([
            'Title' => 'Varchar',
            'Content' => 'HTMLText',
            'ParentID' => 'ForeignKey',
            'MenuTitle' => 'Varchar',
            'Sort' => 'Int',
            'Created' => 'DBDatetime',
            'LastEdited' => 'DBDatetime',
            'MetaDescription' => 'Text',
        ], $specs);

        $specs = $method->invokeArgs($indexCreator, ['members']);
        $this->assertEquals([
            'FirstName' => 'Varchar',
            'Surname' => 'Varchar',
            'Email' => 'Varchar',
        ], $specs);

        $specs = $method->invokeArgs($indexCreator, ['flickrphotos']);
        $this->assertEquals([
            'Title' => 'Varchar',
            'Description' => 'HTMLText',
            'Aperture' => 'Float',
            'ShutterSpeed' => 'Varchar',
            'ISO' => 'Int',
        ], $specs);
    }
}
