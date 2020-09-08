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
     * Index a single data objecct
     */
    public function index(DataObject $dataObject): void;


    /** @param string $newIndexName the name of the index */
    public function setIndexName(string $newIndexName): void;

    // this is provided by the base indexer
    /** @return array<string, array<string,string|int|float|bool|null>> */
    public function getIndexablePayload(\SilverStripe\ORM\DataObject $dataObject): array;
}
