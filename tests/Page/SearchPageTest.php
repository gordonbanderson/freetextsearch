<?php
namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Page\SearchPage;

class SearchPageTest extends SapphireTest
{
    /** @var SearchPage  */
    private $searchPage;

    public function setUp()
    {
        parent::setUp();
        $this->searchPage = new SearchPage();
        $this->searchPage->IndexToSearch = 'flickrphotos';
        $this->searchPage->write();
    }

    public function testGetCMSFields()
    {
        // this will contain the root tab
        $fields = $this->searchPage->getCMSFields();

        /** @var TabSet $rootTab */
        $rootTab = $fields->fieldByName('Root');

        /** @var Tab $indexTab */
        $indexTab = $rootTab->fieldByName('Index');
        $fields = $indexTab->FieldList()->toArray();

        $titles = array_map(function($field) {
            return $field->Name;
        }, $fields);

        $this->assertEquals(['IndexToSearch', 'PageSize', 'ShowTagCloudFor', 'ShowAllIfEmptyQuery'], $titles);
    }

    public function testGetFacets()
    {
        $fields = $this->searchPage->getFacetFields();
        // @todo Check what the case sensitivy issues are here
        $this->assertEquals(['Aperture', 'ShutterSpeed', 'ISO'], $fields);
    }

    public function testGetMany()
    {
        $fields = $this->searchPage->getHasManyFields();
        // @todo Check what the case sensitivy issues are here
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrTag'], $fields);
    }

    public function testGetHasOne()
    {
        $fields = $this->searchPage->getHasOneFields();
        // @todo Check what the case sensitivy issues are here
        $this->assertEquals(['Suilven\ManticoreSearch\Tests\Models\FlickrAuthor'], $fields);
    }

}
