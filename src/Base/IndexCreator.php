<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use Suilven\FreeTextSearch\Indexes;

abstract class IndexCreator implements \Suilven\FreeTextSearch\Interfaces\IndexCreator
{
    public function createIndex($indexName): void
    {
        $indexes = new Indexes();
        $indices = $indexes->getIndexes();

        /** @var \Suilven\FreeTextSearch\Index $indice */
        foreach ($indices as $indice) {
            $clazz = $indice->getClass();
            $classes = $dataObject->getClassAncestry();
            \error_log(\print_r($classes, true));

            foreach ($classes as $indiceClass) {
                    $fields = $indice->getFields();
                    \error_log(\print_r($fields, 1));
            }
        }
    }
}
