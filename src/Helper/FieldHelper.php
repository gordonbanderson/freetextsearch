<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObjectSchema;
use Suilven\FreeTextSearch\Index;
use Suilven\FreeTextSearch\Indexes;

class FieldHelper
{

    /**
     * @param Index $index
     * @param $fieldName
     * @param $fieldValue
     * @return int
     */
    public function getFieldValueCorrectlyTyped($index, $fieldName, $fieldValue)
    {
        $singleton = \singleton((string)($index->getClass()));

        $helper = new IndexingHelper();
        $fields = $helper->getFields($index->getName());

        $schema = $singleton->getSchema();
        $specs = $schema->fieldSpecs((string) $index->getClass(), DataObjectSchema::INCLUDE_CLASS);

        $type = $specs[$fieldName];
        $type = explode('.', $type)[1];


        $value = (string) $fieldValue;
        switch($type) {
            case 'Int':
                $value = intval($fieldValue);
                break;
            case 'Float':
                $value = floatval($fieldValue);
                break;
        }

        return $value;

    }
}
