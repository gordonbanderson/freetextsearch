<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Implementation;

class IdentityIndexablePayloadMutator
{

    public function mutatePayload($dataObjecct, $payload)
    {
        $payload['Link'] = $dataObjecct->Link();

        return $payload;
    }
}
