<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Indexes;

class IndexesTest extends SapphireTest
{
    public function testGetIndex(): void
    {
        $indexes = new Indexes();
        $index = $indexes->getIndex('sitetree');
        $this->assertEquals('sitetree', $index->getName());
        $this->assertEquals([
            'Title',
            'Content',
            'ParentID',
            'MenuTitle',
            'Sort',
            'Created',
            'LastEdited',
        ], $index->getFields());
        $this->assertEquals([], $index->getHasOneFields());
        $this->assertEquals([], $index->getHasManyFields());
        $this->assertEquals([], $index->getTokens());
    }


    /**
     * Assert that index objects are create correctly from the configuration file
     */
    public function testGetIndexes(): void
    {
        $indexes = new Indexes();
        $indices = $indexes->getIndexes();

        $this->assertEquals('sitetree', $indices[0]->getName());
        $this->assertEquals([
            'Title',
            'Content',
            'ParentID',
            'MenuTitle',
            'Sort',
            'Created',
            'LastEdited',
        ], $indices[0]->getFields());
        $this->assertEquals([], $indices[0]->getHasOneFields());
        $this->assertEquals([], $indices[0]->getHasManyFields());
        $this->assertEquals([], $indices[0]->getTokens());

        $this->assertEquals('members', $indices[1]->getName());
        $this->assertEquals([
            'FirstName',
            'Surname',
            'Email',
        ], $indices[1]->getFields());
        $this->assertEquals([], $indices[1]->getHasOneFields());
        $this->assertEquals([], $indices[1]->getHasManyFields());
        $this->assertEquals([], $indices[1]->getTokens());

        $this->assertEquals('flickrphotos', $indices[2]->getName());
        $this->assertEquals([
            'Title',
            'Description',
        ], $indices[2]->getFields());
        $this->assertEquals(['Suilven\FreeTextSearch\Tests\Models\FlickrAuthor'], $indices[2]->getHasOneFields());
        $this->assertEquals(['tags' =>
        [
            'relationship' => 'FlickrTags',
            'field' => 'RawValue',
        ]], $indices[2]->getHasManyFields());
        $this->assertEquals([
            'Aperture',
            'ShutterSpeed',
            'ISO',
        ], $indices[2]->getTokens());
    }


    public function testGetFacetFields(): void
    {
        $indexes = new Indexes();

        $this->assertEquals([
            'Aperture',
            'ShutterSpeed',
            'ISO',
        ], $indexes->getFacetFields('flickrphotos'));
    }


    public function testGetHasOneFields(): void
    {
        $indexes = new Indexes();

        $this->assertEquals(
            ['Suilven\FreeTextSearch\Tests\Models\FlickrAuthor'],
            $indexes->getHasOneFields('flickrphotos')
        );
    }


    public function testGetHasManyFields(): void
    {
        $indexes = new Indexes();

        $this->assertEquals(
            [[
                'name' => 'tags',
                'relationship' => 'FlickrTags',
                'field' => 'RawValue',
            ]],
            $indexes->getHasManyFields('flickrphotos')
        );
    }
}
