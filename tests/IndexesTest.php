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

        /** @var Index $flickrIndex */
        $flickrIndex = $actualIndexes[2];
        $this->assertEquals(['Title', 'Description'], $flickrIndex->getFields());
        $this->assertEquals(['Aperture', 'ShutterSpeed', 'ISO'], $flickrIndex->getTokens());
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrTag'], $flickrIndex->getHasManyFields());
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrAuthor'], $flickrIndex->getHasOneFields());
        $this->assertEquals('flickrphotos', $flickrIndex->getName());
    }
}
