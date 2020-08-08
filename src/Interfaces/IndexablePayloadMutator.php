<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Interfaces;

use SilverStripe\ORM\DataObject;

interface IndexablePayloadMutator
{

    /**
     * @param \SilverStripe\ORM\DataObject $dataObject the data object to index
     * @param array<string,string> $payload the payload to index
     */
    public function mutatePayload(DataObject $dataObject, array &$payload): void;
}
