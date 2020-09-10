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

        $this->assertEquals('sitetree', $indices['sitetree']->getName());
        $this->assertEquals([
            'Title',
            'Content',
            'ParentID',
            'MenuTitle',
            'Sort',
            'Created',
            'LastEdited',
        ], $indices['sitetree']->getFields());
        $this->assertEquals([], $indices['sitetree']->getHasOneFields());
        $this->assertEquals([], $indices['sitetree']->getHasManyFields());
        $this->assertEquals([], $indices['sitetree']->getTokens());

        $this->assertEquals(['Title', 'Content'], $indices['sitetree']->getHighlightedFields());
        $this->assertEquals(['Link'], $indices['sitetree']->getStoredFields());

        $this->assertEquals('members', $indices['members']->getName());
        $this->assertEquals([
            'FirstName',
            'Surname',
            'Email',
        ], $indices['members']->getFields());
        $this->assertEquals([], $indices['members']->getHasOneFields());
        $this->assertEquals([], $indices['members']->getHasManyFields());
        $this->assertEquals([], $indices['members']->getTokens());

        $this->assertEquals('flickrphotos', $indices['flickrphotos']->getName());
        $this->assertEquals([
            'Title',
            'Description',
        ], $indices['flickrphotos']->getFields());
        $this->assertEquals(
            ['Suilven\FreeTextSearch\Tests\Models\FlickrAuthor'],
            $indices['flickrphotos']->getHasOneFields()
        );
        $this->assertEquals(['tags' =>
        [
            'relationship' => 'FlickrTags',
            'field' => 'RawValue',
        ]], $indices['flickrphotos']->getHasManyFields());
        $this->assertEquals([
            'Aperture',
            'ShutterSpeed',
            'ISO',
        ], $indices['flickrphotos']->getTokens());
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
