<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\IndexCreatorFactory;
use Suilven\FreeTextSearch\Helper\SpecsHelper;
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

        $this->assertEquals(['Link'], $indexCreator->getIndexStoredFields());

        $helper = new SpecsHelper();
        $this->assertEquals([
            'Title' => 'Varchar',
            'Content' => 'HTMLText',
            'ParentID' => 'ForeignKey',
            'MenuTitle' => 'Varchar',
            'Sort' => 'Int',
            'Created' => 'DBDatetime',
            'LastEdited' => 'DBDatetime',
            'Link' => 'Varchar',
        ], $helper->getFieldSpecs('sitetree'));

        $this->assertEquals([
            'FirstName' => 'Varchar',
            'Surname' => 'Varchar',
            'Email' => 'Varchar',
        ], $helper->getFieldSpecs('members'));

        $this->assertEquals([
            'Title' => 'Varchar',
            'Description' => 'HTMLText',
            'Aperture' => 'Float',
            'ShutterSpeed' => 'Varchar',
            'ISO' => 'Int',
            // @todo test fails here with missing link
        ], $helper->getFieldSpecs('flickrphotos'));
    }
}
