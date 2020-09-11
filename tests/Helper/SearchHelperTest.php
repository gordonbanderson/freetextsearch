<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Helper;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Helper\SearchHelper;

class SearchHelperTest extends SapphireTest
{
    protected static $fixture_file = ['tests/fixtures/sitetree.yml'];

    public function testTextPayload(): void
    {
        $page = SiteTree::get()->first();
        \error_log($page->Title);

        $helper = new SearchHelper();
        $payload = $helper->getTextFieldPayload($page);
        $this->assertEquals(['sitetree' => [
            'Title' => 'The Break In San Marino Is Bright',
             'Content' => 'The wind in Kenya is waste.',
             'MenuTitle' => 'The Break In San Marino Is Bright',
        ]], $payload);
    }
}
