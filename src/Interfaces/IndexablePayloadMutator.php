<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Interfaces;

interface IndexablePayloadMutator
{

    /**
     * @param \SilverStripe\ORM\DataObject $dataObject the data object to index
     * @param array<string,string> $payload the payload to index
     */
    public function mutatePayload(DataObject $dataObject, array &$payload): void;
}
