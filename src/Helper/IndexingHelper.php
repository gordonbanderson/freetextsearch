<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Factory\IndexablePayloadMutatorFactory;
use Suilven\FreeTextSearch\Indexes;

class IndexingHelper
{
    /**
     * Get a list of index names associated with the data object
     *
     * @return array<string> names of indexes associated with the DataObject in question
     */
    public function getIndexes(DataObject $dataObject): array
    {
        $indexes = new Indexes();
        $indices = $indexes->getIndexes();

        $result = [];

        /** @var \Suilven\FreeTextSearch\Index $indice */
        foreach ($indices as $indice) {
            $clazz = $indice->getClass();
            $classes = $dataObject->getClassAncestry();

            foreach ($classes as $indiceClass) {
                if ($indiceClass !== $clazz) {
                    continue;
                }

                $result[] = $indice->getName();
            }
        }

        return $result;
    }


    /**
     * Get the indexable fields for a given dataobject as an array.  This also includes the stored fields
     *
     * @param \SilverStripe\ORM\DataObject $dataObject get the indexable fields for the provided data object
     * @return array<string, array<string,string|int|float|bool>>
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

                $fields = array_merge($indice->getFields(),$indice->getStoredFields());
                foreach ($fields as $field) {
                    // @phpstan-ignore-next-line
                    $value = $dataObject->$field;
                    $indicePayload[$field] = $value;
                }
            }
            $payload[$indice->getName()] = $indicePayload;
        }

        $factory = new IndexablePayloadMutatorFactory();
        $mutator = $factory->getIndexablePayloadMutator();
        $mutator->mutatePayload($dataObject, $payload);

        return $payload;
    }
}
