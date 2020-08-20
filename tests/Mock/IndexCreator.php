<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Tests\Mock;

// @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
class IndexCreator extends \Suilven\FreeTextSearch\Base\IndexCreator implements
    \Suilven\FreeTextSearch\Interfaces\IndexCreator
{

    /** @var string */
    private static $indexName;

    public function createIndex(string $indexName): void
    {
        self::$indexName = $indexName;
    }


    public static function getIndexName(): string
    {
        return self::$indexName;
    }
}
