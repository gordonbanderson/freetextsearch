<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Page;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Container\SearchResults;
use Suilven\FreeTextSearch\Page\SearchPage;

class SearchPageTest extends SapphireTest
{
    protected static $fixture_file = ['tests/fixtures/pages.yml'];


    public function testGetIndex(): void
    {
        /** @var \Suilven\FreeTextSearch\Page\SearchPage $photoSearchPage */
        $photoSearchPage = $this->objFromFixture(SearchPage::class, 'photo-search');

        $this->assertEquals('flickrphotos', $photoSearchPage->IndexToSearch);
    }


    public function testGetFacets(): void
    {
        /** @var \Suilven\FreeTextSearch\Page\SearchPage $photoSearchPage */
        $photoSearchPage = $this->objFromFixture(SearchPage::class, 'photo-search');

        $this->assertEquals([
            'Aperture',
            'ShutterSpeed',
            'ISO',
        ], $photoSearchPage->getFacetFields());
    }


    public function testGetHasManyFields(): void
    {
        /** @var \Suilven\FreeTextSearch\Page\SearchPage $photoSearchPage */
        $photoSearchPage = $this->objFromFixture(SearchPage::class, 'photo-search');

        $this->assertEquals([
            'Suilven\FreeTextSearch\Tests\Models\FlickrTag',
        ], $photoSearchPage->getHasManyFields());
    }


    public function testGetCMSFields(): void
    {
        /** @var \Suilven\FreeTextSearch\Page\SearchPage $photoSearchPage */
        $photoSearchPage = $this->objFromFixture(SearchPage::class, 'photo-search');

        $fields = $photoSearchPage->getCMSFields();
        /** @var \Suilven\FreeTextSearch\Tests\Page\TabSet $rootTab */
        $rootTab = $fields->fieldByName('Root');

        /** @var \Suilven\FreeTextSearch\Tests\Page\Tab $mainTab */
        $mainTab = $rootTab->fieldByName('Index');
        $fields = $mainTab->FieldList();

        // This is present for PostgresSQL on Travis only
        $fields->removeByName('InstallWarningHeader');

        $names = \array_map(
            static function ($field) {
                return $field->Name;
            },
            $fields->toArray()
        );
        $this->assertEquals([
            'IndexToSearch',
            'PageSize',
            'ShowTagCloudFor',
            'ShowAllIfEmptyQuery',
        ], $names);
    }


    public function testSetGetSearchResults(): void
    {
        /** @var \Suilven\FreeTextSearch\Page\SearchPage $photoSearchPage */
        $photoSearchPage = $this->objFromFixture(SearchPage::class, 'photo-search');

        $searchResults = new SearchResults();
        $searchResults->setQuery('test');
        $searchResults->setTime(9.58);

        $photoSearchPage->setSearchResults($searchResults);

        $obtainedSearchResults = $photoSearchPage->getSearchResults();
        $this->assertEquals('test', $obtainedSearchResults->getQuery());
        $this->assertEquals(9.58, $obtainedSearchResults->getTime());
    }
}
