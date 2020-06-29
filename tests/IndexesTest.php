<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Index;
use Suilven\FreeTextSearch\Indexes;

class IndexesTest extends SapphireTest
{
    /**
     * Assert that index objects are create correctly from the configuration file
     */
    public function testGetIndexes()
    {
        $indexes = new Indexes();
        $indices = $indexes->getIndexes();

        $this->assertEquals('sitetree', $indices[0]->getName());
        $this->assertEquals([
            'Title',
            'MenuTitle',
            'Content',
            'ParentID',
            'Sort'
        ], $indices[0]->getFields());
        $this->assertEquals([], $indices[0]->getHasOneFields());
        $this->assertEquals([], $indices[0]->getHasManyFields());
        $this->assertEquals([], $indices[0]->getTokens());

        $this->assertEquals('members', $indices[1]->getName());
        $this->assertEquals([
            'FirstName',
            'Surname',
            'Email'
        ], $indices[1]->getFields());
        $this->assertEquals([], $indices[1]->getHasOneFields());
        $this->assertEquals([], $indices[1]->getHasManyFields());
        $this->assertEquals([], $indices[1]->getTokens());

        $this->assertEquals('flickrphotos', $indices[2]->getName());
        $this->assertEquals([
            'Title',
            'Description'
        ], $indices[2]->getFields());
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrAuthor'], $indices[2]->getHasOneFields());
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrTag'], $indices[2]->getHasManyFields());
        $this->assertEquals([
            'Aperture',
            'ShutterSpeed',
            'ISO'
        ], $indices[2]->getTokens());

    }


    public function testGetFacetFields()
    {
        $indexes = new Indexes();

        // @todo Why is this being lowercased
        $this->assertEquals([
            'aperture',
            'shutterspeed',
            'iso'
        ], $indexes->getFacetFields('flickrphotos'));
    }


    public function testGetHasOneFields()
    {
        $indexes = new Indexes();

        // @todo Why is this being lowercased
        $this->assertEquals(['suilven\manticoresearch\tests\models\flickrauthor'],
            $indexes->getHasOneFields('flickrphotos'));
    }


    public function testGetHasManyFields()
    {
        $indexes = new Indexes();

        // @todo Why is this being lowercased
        $this->assertEquals(['suilven\manticoresearch\tests\models\flickrtag'],
            $indexes->getHasManyFields('flickrphotos'));
    }
}
