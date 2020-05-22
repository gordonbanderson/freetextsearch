<?php
namespace Suilven\FreeTextSearch\Tests;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Index;
use Suilven\FreeTextSearch\Indexes;

class IndexesTest extends SapphireTest
{
    /** @var Indexes */
    private $indexes;

    public function setUp()
    {
        parent::setUp();
        $this->indexes = new Indexes();
    }

    public function testGetIndexesSingleIndex()
    {
        $actualIndexes = $this->indexes->getIndexes();

        /** @var Index $flickrIndex */
        $flickrIndex = $actualIndexes[2];
        $this->assertEquals(['Title', 'Description'], $flickrIndex->getFields());
        $this->assertEquals(['Aperture', 'ShutterSpeed', 'ISO'], $flickrIndex->getTokens());
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrTag'], $flickrIndex->getHasManyFields());
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrAuthor'], $flickrIndex->getHasOneFields());
        $this->assertEquals('flickrphotos', $flickrIndex->getName());
    }

    public function testGetFacetsForIndex()
    {
        $fields = $this->indexes->getFacetFields('flickrphotos');
        // @todo Check what the case sensitivy issues are here
        $this->assertEquals(['Aperture', 'ShutterSpeed', 'ISO'], $fields);
    }

    public function testGetHasOneFieldsForIndex()
    {
        $fields = $this->indexes->getHasOneFields('flickrphotos');
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrAuthor'], $fields);
    }

    public function testGetHasManyFieldsForIndex()
    {
        $fields = $this->indexes->getHasManyFields('flickrphotos');
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrTag'], $fields);
    }
}
