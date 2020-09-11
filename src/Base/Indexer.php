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


    /** @param string $newIndexName the new index name */
    public function setIndexName(string $newIndexName): void
    {
        $this->indexName = $newIndexName;
    }


    /**
     * index name -> field name -> list of values
     *
     * @return array<string, array<string, array|bool|float|int|string>>
    */
    public function getIndexablePayload(\SilverStripe\ORM\DataObject $dataObject): array
    {
        $helper = new IndexingHelper();

        $payload = $helper->getFieldsToIndex($dataObject);

        $indexes = new Indexes();
        $index = $indexes->getIndex($this->indexName);

        // populate MVA columns
        $mvaColumns = $index->getHasManyFields();


        /** @var string $mvaColumnName */
        foreach (\array_keys($mvaColumns) as $mvaColumnName) {
            $relationship = $mvaColumns[$mvaColumnName]['relationship'];

            // @phpstan-ignore-next-line
            $relationshipDOs = $dataObject->$relationship();

            /** @var array $values */
            $values = [];
            foreach ($relationshipDOs as $mvaDO) {
                $values[] = $mvaDO->ID;
            }

            $payload[$this->indexName][$mvaColumnName] = $values;
        }

        return $payload;
    }
}
