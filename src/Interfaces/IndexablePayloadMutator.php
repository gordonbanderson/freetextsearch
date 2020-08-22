<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Interfaces;

use SilverStripe\ORM\DataObject;

interface IndexablePayloadMutator
{

    /**
     * Note the payload is indexname --> [field name --> field value], as a dataobject may belong to multiple indexes,
     * for example a BlogPost extending SiteTree could be in both the sitetree and blogpost indexes
     *
     * @param \SilverStripe\ORM\DataObject $dataObject the data object to index
     * @param array<string,array<string,int|float|string|bool>> $payload the payload to index
     */
    public function mutatePayload(DataObject $dataObject, array &$payload): void;
}
