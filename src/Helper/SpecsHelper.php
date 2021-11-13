<?php

declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObjectSchema;
use Suilven\FreeTextSearch\Indexes;

class SpecsHelper
{
    /**
     * Helper method to get get field specs for a DataObject relevant to it's index definition
     *
     * @param string $indexName the name of the index
     * @return array<string,string>
     */
    public function getFieldSpecs(string $indexName): array
    {
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);
        $singleton = \singleton($index->getClass());

        $helper = new IndexingHelper();
        $fields = $helper->getFields($indexName);

        /** @var \SilverStripe\ORM\DataObjectSchema $schema */
        $schema = $singleton->getSchema();
        $specs = $schema->fieldSpecs($index->getClass(), DataObjectSchema::INCLUDE_CLASS);

        /** @var array<string,string> $filteredSpecs the DB specs for fields related to the index */
        $filteredSpecs = [];

        foreach ($fields as $field) {
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

        // if Link undefined in the original index specs, add it if the method exists on the singleton dataobject
        if (!isset($filteredSpecs['Link'])) {
            if (\method_exists($singleton, 'Link')) {
                $filteredSpecs['Link'] = 'Varchar';
            }
        }

        return $filteredSpecs;
    }
}
