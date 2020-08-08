<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

use SilverStripe\ORM\DataObject;

// @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
class BulkIndexer implements \Suilven\FreeTextSearch\Interfaces\BulkIndexer
{

    public function addDataObject(DataObject $dataObject): void
    {
        // TODO: Implement addDataObject() method.
    }


    public function indexDataObjects(): void
    {
        // TODO: Implement indexDataObjects() method.
    }


    public function setIndex(string $newIndex): void
    {
        // TODO: Implement setIndex() method.
    }
}
