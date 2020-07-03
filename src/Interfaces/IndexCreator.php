<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Interfaces;

interface IndexCreator
{

    /** @param \Suilven\FreeTextSearch\Interfaces\DataObject $dataObject */
    public function createIndex($indexName): void;
}
