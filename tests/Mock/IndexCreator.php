<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Mock;

use SilverStripe\ORM\DataObject;

// @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
class IndexCreator implements \Suilven\FreeTextSearch\Interfaces\IndexCreator
{

    public function createIndex(string $indexName): void
    {
        // TODO: Implement createIndex() method.
    }
}
