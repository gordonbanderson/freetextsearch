<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use Suilven\FreeTextSearch\Indexes;

abstract class Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var string */
    protected $index;

    abstract public function index($dataObject): void;


    public function processIndexes(DataObject $dataObject): void
    {
    }


    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }


    protected function getFieldsToIndex($dataObject)
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
