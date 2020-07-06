<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Indexes;

abstract class Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var string */
    protected $index;

    /**
     * Index a single data objecct
     *
     * @param \SilverStripe\ORM\DataObject $dataObject
     */
    abstract public function index(DataObject $dataObject): void;


    /** @param string $newIndex the new index name */
    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }



}
