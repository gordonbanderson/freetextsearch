<?php

declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Page;

use SilverStripe\Dev\FunctionalTest;
use Suilven\FreeTextSearch\Page\SearchPage;
use Suilven\FreeTextSearch\Tests\Models\FlickrPhoto;

class SearchPageControllerTest extends FunctionalTest
{
    protected static $fixture_file = [
        'tests/fixtures/pages.yml',
        'tests/fixtures/sitetree.yml',
        'tests/fixtures/flickrphotos.yml',
    ];

    protected static $extra_dataobjects = [
        FlickrPhoto::class,
    ];


    public function testEmptySearchNoResults(): void
    {
        $this->markTestSkipped('@todo');
    }


    public function testEmptySearchShowResults(): void
    {
        $this->markTestSkipped('@todo');
    }


    public function testSearch(): void
    {
        /** @var \Suilven\FreeTextSearch\Page\SearchPage $photoSearchPage */
        $photoSearchPage = $this->objFromFixture(SearchPage::class, 'photo-search');
        $photoSearchPage->publishRecursive();

        $this->assertInstanceOf('Suilven\FreeTextSearch\Page\SearchPage', $photoSearchPage);

        $page = $this->get('/photo-search/?q=Fish');
        \error_log('PAGE:');
        \error_log($page->getBody());

        // @todo assertions
    }


    public function testSearchNotFirstPage(): void
    {
        /** @var \Suilven\FreeTextSearch\Page\SearchPage $photoSearchPage */
        $photoSearchPage = $this->objFromFixture(SearchPage::class, 'photo-search');
        $photoSearchPage->publishRecursive();

        $this->assertInstanceOf('Suilven\FreeTextSearch\Page\SearchPage', $photoSearchPage);

        $page = $this->get('/photo-search/?q=Fish&start=10');
        \error_log('PAGE:');
        \error_log($page->getBody());

        // @todo more search results and assertions
    }
}
