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
use Suilven\FreeTextSearch\Indexes;

abstract class Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{
    /** @var string */
    protected $indexName;

    /**
     * Index a single data object
     */
    abstract public function index(DataObject $dataObject): void;


    /** @param string $newIndex the new index name */
    public function setIndexName(string $newIndexName): void
    {
        $this->indexName = $newIndexName;
    }


    /** @return array<string, array<string,string|int|float|bool>> */
    public function getIndexablePayload(\SilverStripe\ORM\DataObject $dataObject): array
    {
        $helper = new IndexingHelper();

        $payload = $helper->getFieldsToIndex($dataObject);

        $indexes = new Indexes();
        $index = $indexes->getIndex($this->indexName);

        // populate MVA columns
        $mvaColumns = $index->getHasManyFields();
        foreach(array_keys($mvaColumns) as $mvaColumnName) {
            $relationship = $mvaColumns[$mvaColumnName]['relationship'];
            $fieldname = $mvaColumns[$mvaColumnName]['field'];
            $relationshipDOs = $dataObject->$relationship();
            $values = [];
            foreach($relationshipDOs as $mvaDO) {
                $values[] = $mvaDO->ID;
            }

            $payload[$this->indexName][$mvaColumnName] = $values;
        }

        return $payload;
    }
}
