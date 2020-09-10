<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Implementation;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Interfaces\IndexablePayloadMutator;

class AddLinkIndexablePayloadMutator implements IndexablePayloadMutator
{
    /**
     * @param \SilverStripe\ORM\DataObject $dataObject the data object to index
     * @param array<string,array<string,int|float|string|bool>> $payload the payload to index
     */
    public function mutatePayload(DataObject $dataObject, array &$payload): void
    {
        if (!\method_exists($dataObject, 'Link')) {
            return;
        }

        $keys = \array_keys($payload);
        foreach ($keys as $key) {
            if ($payload[$key] !== []) {
                $payload[$key]['Link'] = $dataObject->Link();
            };
        }
    }
}
