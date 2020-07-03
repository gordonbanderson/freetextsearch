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

    /**
     * Index a single data objecct
     *
     * @param \SilverStripe\ORM\DataObject $dataObject
     */
    public function index(DataObject $dataObject): void;


    /** @param string $newIndex the name of the index */
    public function setIndex(string $newIndex): void;
}
