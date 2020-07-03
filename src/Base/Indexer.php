<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Indexes;

abstract class Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var string */
    protected $index;

    /**
     * Index a single data objecct
     *
     * @param \SilverStripe\ORM\DataObject $dataObject
     */
    abstract public function index(DataObject $dataObject): void;


    /** @param string $newIndex the new index name */
    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }


    /**
     * Get the indexable fields for a given dataobject as an array
     *
     * @param \SilverStripe\ORM\DataObject $dataObject get the indexable fields for the provided data object
     * @return array<string>
     */
    protected function getFieldsToIndex(DataObject $dataObject): array
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
        }

        return $payload;
    }
}
