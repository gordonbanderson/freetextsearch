<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Helper\IndexingHelper;

abstract class Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var string */
    protected $index;

    /**
     * Index a single data object
     */
    abstract public function index(DataObject $dataObject): void;


    /** @param string $newIndex the new index name */
    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }


    /** @return array<string, array<string,string|int|float|bool>> */
    protected function getIndexablePayload(\SilverStripe\ORM\DataObject $dataObject): array
    {
        $helper = new IndexingHelper();

        return $helper->getFieldsToIndex($dataObject);
    }
}
