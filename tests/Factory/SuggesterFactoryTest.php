<?php
namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\SuggesterFactory;
use Suilven\FreeTextSearch\Index;

class SuggesterFactoryTest extends SapphireTest
{
    public function testSuggesterFactory()
    {
        $factory = new SuggesterFactory();
        $instance = $factory->getSuggester();
        $this->assertInstanceOf('Suilven\ManticoreSearch\Service\Suggester', $instance);
    }
}
