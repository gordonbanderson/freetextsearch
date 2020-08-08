<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\IndexCreatorFactory;

class IndexCreatorFactoryTest extends SapphireTest
{
    public function testFactory(): void
    {
        $factory = new IndexCreatorFactory();
        $indexCreator = $factory->getIndexCreator();
        $this->assertInstanceOf('Suilven\FreeTextSearch\Interfaces\IndexCreator', $indexCreator);
        $this->assertInstanceOf('Suilven\FreeTextSearch\Tests\Mock\IndexCreator', $indexCreator);
    }
}
