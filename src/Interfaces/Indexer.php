<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Interfaces;

interface Indexer
{

    public function index(DataObject $dataObject): void;


    public function processIndexes($dataObject): void;


    /** @param string $newIndex the name of the index */
    public function setIndex(string $newIndex): void;
}
