<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Interfaces;

use SilverStripe\ORM\DataObject;

interface BulkIndexer
{

    /**
     * Index a single data objecct
     *
     * @param \SilverStripe\ORM\DataObject $dataObject
     */
    public function addDataObject(DataObject $dataObject): void;

    public function indexDataObjects();




    /** @param string $newIndex the name of the index */
    public function setIndex(string $newIndex): void;
}
