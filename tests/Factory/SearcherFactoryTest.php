<?php
namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\SearcherFactory;

class SearcherFactoryTest extends SapphireTest
{
    public function testSearcherFactory()
    {
        $factory = new SearcherFactory();
        $instance = $factory->getSearcher();
        $this->assertInstanceOf('Suilven\ManticoreSearch\Service\Searcher', $instance);
    }
}
