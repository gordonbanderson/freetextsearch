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
class Indexer extends \Suilven\FreeTextSearch\Base\Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var null|array<string,string|int|float|bool> */
    private $payload;


    // @phpstan-ignore-next-line
    public function index(DataObject $dataObject): void
    {
        $this->payload = $this->getIndexablePayload($dataObject);
    }

    public function getIndexedPayload()
    {
        return $this->payload;
    }
}
