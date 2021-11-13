<?php

declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\SearcherFactory;

class SearcherFactoryTest extends SapphireTest
{
    public function testFactory(): void
    {
        $factory = new SearcherFactory();
        $searcher = $factory->getSearcher();
        $this->assertInstanceOf('Suilven\FreeTextSearch\Interfaces\Searcher', $searcher);
        $this->assertInstanceOf('Suilven\FreeTextSearch\Tests\Mock\Searcher', $searcher);
    }
}
