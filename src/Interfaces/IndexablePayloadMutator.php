<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Interfaces;

use SilverStripe\ORM\DataObject;

interface IndexablePayloadMutator
{

    /**
     * @param DataObject $dataObject the data object to index
     * @param array<string,string> $payload the payload to index
     */
    public function mutatePayload($dataObject, $payload): void;
}
