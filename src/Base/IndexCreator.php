<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use SilverStripe\ORM\DataObjectSchema;
use Suilven\FreeTextSearch\Indexes;

abstract class IndexCreator implements \Suilven\FreeTextSearch\Interfaces\IndexCreator
{
    /**
     * (Re)create an index of the given name, using the index configuration from YML
     *
     * @param string $indexName The name of the index
     */
    abstract public function createIndex(string $indexName): void;


    /**
     * Helper method to get get field specs for a DataObject relevant to it's index definition
     *
     * @param string $indexName the name of the index
     * @return array<string,string>
     */
    protected function getFieldSpecs(string $indexName): array
    {
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);
        $singleton = \singleton($index->getClass());

        $fields = $this->getFields($indexName);

        \error_log(\print_r($fields, true));

        /** @var \SilverStripe\ORM\DataObjectSchema $schema */
        $schema = $singleton->getSchema();
        $specs = $schema->fieldSpecs($index->getClass(), DataObjectSchema::INCLUDE_CLASS);

        /** @var array<string,string> $filteredSpecs the DB specs for fields related to the index */
        $filteredSpecs = [];

        foreach ($fields as $field) {
            \error_log('CHECKING FIELD ' . $field);

            if ($field === 'Link') {
                continue;
            }
            $fieldType = $specs[$field];

            // fix likes of varchar(255)
            $fieldType = \explode('(', $fieldType)[0];

            // remove the class name
            $fieldType = \explode('.', $fieldType)[1];

            $filteredSpecs[$field] = $fieldType;
        }

        if (!isset($filteredSpecs['Link'])) {
            $filteredSpecs['Link'] = 'Varchar';
        }

        return $filteredSpecs;
    }


    /** @return array<string,string> */
    protected function getFields(string $indexName): array
    {
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);

        $fields = [];

        foreach ($index->getFields() as $field) {
            $fields[] = $field;
        }

        foreach ($index->getTokens() as $token) {
            $fields[] = $token;
        }

        if (!\in_array('Link', $fields, true)) {
            $fields[] = 'Link';
        }

        return $fields;
    }
}
