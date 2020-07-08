<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Indexes;

class IndexingHelper
{
    /**
     * Get the indexable fields for a given dataobject as an array
     *
     * @param \SilverStripe\ORM\DataObject $dataObject get the indexable fields for the provided data object
     * @return array<string>
     */
    public function getFieldsToIndex(DataObject $dataObject): array
    {
        $indexes = new Indexes();
        $indices = $indexes->getIndexes();

        $payload = [];

        /** @var \Suilven\FreeTextSearch\Index $indice */
        foreach ($indices as $indice) {
            $indicePayload = [];

            $clazz = $indice->getClass();
            $classes = $dataObject->getClassAncestry();

            foreach ($classes as $indiceClass) {
                if ($indiceClass !== $clazz) {
                    continue;
                }

                $fields = $indice->getFields();
                foreach ($fields as $field) {
                    $value = $dataObject->$field;
                    $indicePayload[$field] = $value;
                }
            }
            $payload[$indice->getName()] = $indicePayload;

            // this halves indexing speed
            $payload['Link'] = $dataObject->Link();
            $payload['AbsoluteLink'] = $dataObject->AbsoluteLink();
        }

        // @todo a possible mutator, specific to different search engines, may be required here

        return $payload;
    }
}
