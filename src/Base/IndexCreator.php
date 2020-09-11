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
     * @param string $indexName The name of the index
     */
    abstract public function createIndex(string $indexName): void;


    /** @return array<string> */
    protected function getStoredFields(string $indexName): array
    {
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);

        return $index->getStoredFields();
    }
}
