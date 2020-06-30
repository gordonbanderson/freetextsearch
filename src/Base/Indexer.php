<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Index;
use Suilven\FreeTextSearch\Indexes;

abstract class Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var string */
    protected $index;

    public abstract function index($dataObject);

    /**
     * @param DataObject $dataObject
     */
    public function processIndexes($dataObject)
    {
        $indexes = new Indexes();
        $indices = $indexes->getIndexes();

        /** @var Index $index */
        foreach($indices as $index)
        {
            $clazz = $index->getClass();
            $classes = $dataObject->getClassAncestry();
            error_log(print_r($classes, 1));
        }
    }


    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }
}
