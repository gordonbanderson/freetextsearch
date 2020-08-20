<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Helper\IndexingHelper;

// @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
class BulkIndexer implements \Suilven\FreeTextSearch\Interfaces\BulkIndexer
{

    /** @var string */
    private static $indexName;

    /** @var array<string, (string|int|float|bool)>|null */
    private static $payload = [];


    public function addDataObject(DataObject $dataObject): void
    {
        $helper = new IndexingHelper();

        $payload = $helper->getFieldsToIndex($dataObject);

        // as we are not indexing against a real free text search engine, add the ID into the payload for testing
        $payload['ID'] = $dataObject->ID;
        self::$payload[] = $payload;
    }


    public function indexDataObjects(): void
    {
        // noop - this is a mock, so no implementation required
    }


    public function setIndex(string $newIndex): void
    {
        self::$indexName = $newIndex;
    }

    public static function getIndexName()
    {
        return self::$indexName;
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
