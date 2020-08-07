<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\IndexablePayloadMutatorFactory;

class IndexablePayloadMutatorFactoryTest extends SapphireTest
{
    public function testFactory(): void
    {
        $factory = new IndexablePayloadMutatorFactory();
        $indexCreator = $factory->getIndexablePayloadMutator();
        $this->assertInstanceOf('Suilven\FreeTextSearch\Interfaces\IndexablePayloadMutator', $indexCreator);
        $this->assertInstanceOf(
            'Suilven\FreeTextSearch\Implementation\IdentityIndexablePayloadMutator',
            $indexCreator
        );
    }
}
