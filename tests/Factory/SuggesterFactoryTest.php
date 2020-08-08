<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\SuggesterFactory;

class SuggesterFactoryTest extends SapphireTest
{
    public function testFactory(): void
    {
        $factory = new SuggesterFactory();
        $suggester = $factory->getSuggester();
        $this->assertInstanceOf('Suilven\FreeTextSearch\Interfaces\Suggester', $suggester);
        $this->assertInstanceOf('Suilven\FreeTextSearch\Tests\Mock\Suggester', $suggester);

        $suggestions = $suggester->suggest('webmister');
        $this->assertEquals(['webmaster'], $suggestions->getResults());
    }

    // @todo test set limit
}
