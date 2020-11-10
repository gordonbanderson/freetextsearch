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

class FieldHelper
{

    /**
     * @param string|int|float|bool $fieldValue
     * @return float|int|string|bool
    */
    public function getFieldValueCorrectlyTyped(Index $index, string $fieldName, $fieldValue)
    {
        $tokens = $index->getTokens();
        $hasManyFields = $index->getHasManyFields();
        $hasManyKeys = \array_keys($hasManyFields);
        $hasOneFields = $index->getHasOneFields();
        $hasOneKeys = \array_keys($hasOneFields);

        $result = '';
        if (\in_array($fieldName, $tokens, true)) {
            $result = $this->getSingleValueAttributeCorrectlyTyped($index, $fieldName, $fieldValue);
        } elseif (\in_array($fieldName, $hasManyKeys, true)) {
            $details = $hasManyFields[$fieldName];
            $result = $this->getFieldValueCorrectlyTypedFor(
                $details['class'],
                $details['field'],
                $fieldValue
            );

            $singleton = \singleton($details['class']);
            $objInContext = $singleton->get()->filter($details['field'], $fieldValue)->first();

            $result = $objInContext->ID;
        } elseif (\in_array($fieldName, $hasOneKeys, true)) {
            $result = \intval($fieldValue);
        }

        return $result;
    }


    /**
     * @param string|int|float|bool $fieldValue
     * @return float|int|string|bool
     */
    public function getSingleValueAttributeCorrectlyTyped(Index $index, string $fieldName, $fieldValue)
    {
        return $this->getFieldValueCorrectlyTypedFor($index->getClass(), $fieldName, $fieldValue);
    }


    /**
     * @param string|int|float|bool $fieldValue
     * @return float|int|string|bool
     */
    private function getFieldValueCorrectlyTypedFor(string $clazz, string $fieldName, $fieldValue)
    {
        $singleton = \singleton($clazz);
        $schema = $singleton->getSchema();
        $specs = $schema->fieldSpecs($clazz, DataObjectSchema::INCLUDE_CLASS);

        $type = $specs[$fieldName];
        $type = \explode('.', $type)[1];


        $value = (string) $fieldValue;
        switch ($type) {
            case 'Int':
                $value = \intval($fieldValue);

                break;
            case 'Float':
                $value = \floatval($fieldValue);

                break;
            case 'Boolean':
                $value = \boolval($fieldValue);

                break;
        }

        return $value;
    }
}
