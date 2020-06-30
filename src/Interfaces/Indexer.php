<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Interfaces;

use SilverStripe\ORM\DataObject;

interface Indexer
{

    /**
     * @param DataObject $dataObject
     */
    public function index($dataObject);


    public function processIndexes($dataObject);

    public function addDataObjectToIndex($dataObject, $index);




    /** @param string $newIndex the name of the index */
    public function setIndex(string $newIndex): void;
}
