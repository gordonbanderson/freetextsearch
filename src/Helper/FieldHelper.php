<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObject;
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
        $tokens = $index->getTokens();
        $hasManyFields = $index->getHasManyFields();
        $hasManyKeys = array_keys($hasManyFields);

        $result = null;
        if (in_array($fieldName, $tokens)) {
            $result = $this->getSingleValueAttributeCorrectlyTyped($index, $fieldName, $fieldValue);
        }
        // @todo Has one
        if (in_array($fieldName, $hasManyKeys)) {
            $details = $hasManyFields[$fieldName];
            $result = $this->getFieldValueCorrectlyTypedFor(
                $details['class'],
                $details['field'],
                $fieldValue
            );

            $singleton = \singleton($details['class']);
            $objInContext = $singleton->get()->filter($details['field'], $fieldValue)->first();

            $result = [$objInContext->ID];
        }

        /*
         * ===============================Array
(
    [q] => fish
    [Tags] => Salton
)
Array
(
    [Tags] => Array
        (
            [relationship] => FlickrTags
            [field] => RawValue
            [class] => Suilven\Flickr\Model\Flickr\FlickrTag
        )

)

         */

        return $result;
    }



    /**
     * @param Index $index
     * @param $fieldName
     * @param $fieldValue
     * @return int
     */
    public function getSingleValueAttributeCorrectlyTyped($index, $fieldName, $fieldValue)
    {
        return $this->getFieldValueCorrectlyTypedFor($index->getClass(), $fieldName, $fieldValue);
    }


    /**
     * @param string $clazz
     * @param string $fieldName
     * @param $fieldValue
     * @return float|int|string
     */
    private function getFieldValueCorrectlyTypedFor($clazz, $fieldName, $fieldValue) {
        $singleton = \singleton($clazz);
        $schema = $singleton->getSchema();
        $specs = $schema->fieldSpecs($clazz, DataObjectSchema::INCLUDE_CLASS);

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
