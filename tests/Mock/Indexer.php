<?php

declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

use SilverStripe\ORM\DataObject;

// @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
class Indexer extends \Suilven\FreeTextSearch\Base\Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var array<string, (string|int|float|bool)>|null */
    private static $payload = [];


    // @phpstan-ignore-next-line
    public function index(DataObject $dataObject): void
    {
        self::$payload[] = $this->getIndexablePayload($dataObject);
    }


    /** @return array<string, (string|int|float|bool)>|null */
    public static function getIndexedPayload(): ?array
    {
        return self::$payload;
    }


    public static function resetIndexedPayload(): void
    {
        self::$payload = [];
    }
}
