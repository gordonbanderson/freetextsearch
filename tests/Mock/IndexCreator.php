<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Mock;

// @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
class IndexCreator extends \Suilven\FreeTextSearch\Base\IndexCreator implements \Suilven\FreeTextSearch\Interfaces\IndexCreator
{

    public function createIndex(string $indexName): void
    {
        parent::createIndex($indexName);
    }
}
