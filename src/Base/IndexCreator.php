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

abstract class IndexCreator implements \Suilven\FreeTextSearch\Interfaces\IndexCreator
{
    public function createIndex($indexName)
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
                    $fields = $indice->getFields();
                    error_log(print_r($fields, 1));

            }

        }
    }


}
