<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObjectSchema;
use Suilven\FreeTextSearch\Indexes;

class FieldHelper
{

    public function getFieldValueCorrectlyTyped($index, $fieldName, $fieldValue)
    {
        /*
        $indexes = new Indexes();
        $index = $indexes->getIndex($indexName);
        $singleton = \singleton((string)($index->getClass()));

        $helper = new IndexingHelper();
        $fields = $helper->getFields($indexName);

        $schema = $singleton->getSchema();
        $specs = $schema->fieldSpecs((string) $index->getClass(), DataObjectSchema::INCLUDE_CLASS);

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
        */

        return 400;
    }
}
