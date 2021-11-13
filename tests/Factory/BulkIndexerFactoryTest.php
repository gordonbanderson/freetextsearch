<?php

declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Factory;

use SilverStripe\Dev\SapphireTest;
use Suilven\FreeTextSearch\Factory\BulkIndexerFactory;

class BulkIndexerFactoryTest extends SapphireTest
{
    public function testFactory(): void
    {
        $factory = new BulkIndexerFactory();
        $bulkIndexer = $factory->getBulkIndexer();
        $this->assertInstanceOf('Suilven\FreeTextSearch\Interfaces\BulkIndexer', $bulkIndexer);
        $this->assertInstanceOf('Suilven\FreeTextSearch\Tests\Mock\BulkIndexer', $bulkIndexer);
    }
}
