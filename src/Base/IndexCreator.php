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
    /**
     * (Re)create an index of the given name, using the index configuration from YML
     *
     * @todo Tidy up this method in conjunction with manticore search module
     * @param string $indexName The name of the index
     */
    public function createIndex(string $indexName): void
    {
        $indexes = new Indexes();
        $indices = $indexes->getIndexes();

        /** @var \Suilven\FreeTextSearch\Index $indice */
        foreach ($indices as $indice) {
            $clazz = $indice->getClass();
            // @phpstan-ignore-next-line
            $instance = \Singleton::getInstance($clazz);
            $classes = $instance->getClassAncestry();

            foreach ($classes as $indiceClass) {
                    $fields = $indice->getFields();
            }
        }
    }
}
