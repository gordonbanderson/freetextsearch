<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Index;
use Suilven\FreeTextSearch\Indexes;
use Suilven\ManticoreSearch\Service\Client;

abstract class Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var string */
    protected $index;

    public function index($dataObject)
    {
        $indexes = new Indexes();
        $indices = $indexes->getIndexes();

        /** @var Index $indice */
        foreach($indices as $indice)
        {
            $clazz = $indice->getClass();
            $classes = $dataObject->getClassAncestry();
            error_log(print_r($classes, true));

            foreach($classes as $indiceClass)
            {
                if ($indiceClass == $clazz) {
                    $fields = $indice->getFields();
                    foreach($fields as $field)
                    {
                        $value = $dataObject->$field;
                        $payload[$field] = $value;
                    }

                    error_log(print_r($payload, true));

                    $coreClient = new Client();
                    $client = $coreClient->getConnection();
                    $manticoreIndex = new \Manticoresearch\Index($client, $indice->getName());
                    $manticoreIndex->addDocument($payload, $dataObject->ID);
                }
            }

        }
    }

    public abstract function addDataObjectToIndex($dataObject, $index) ;


    /**
     * @param DataObject $dataObject
     */
    public function processIndexes($dataObject)
    {

    }


    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }
}
