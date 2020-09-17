<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Indexes;

class SearchHelper
{
    /**
     * @param \SilverStripe\ORM\DataObject $dataObject the dataobject to extra text from
     * @return array<string,array<string,string>>
     */
    public function getTextFieldPayload(DataObject $dataObject): array
    {
        $helper = new IndexingHelper();
        $fullPayload = $helper->getFieldsToIndex($dataObject);
        $textPayload = [];

        $keys = \array_keys($fullPayload);
        $specsHelper = new SpecsHelper();


        foreach ($keys as $indexKey) {
            $indexes = new Indexes();
            $index = $indexes->getIndex($indexKey);
            $textualFields = $index->getFields();

            // if the index details are empty, skip
            if ($fullPayload[$indexKey] === []) {
                continue;
            }

            $textPayload[$indexKey] = [];
            $specs = $specsHelper->getFieldSpecs($indexKey);

            foreach (\array_keys($specs) as $field) {
                // skip non textual fields
                if (!in_array($field, $textualFields, true)) {
                    continue;
                }


                $type = $specs[$field];
                if (!\in_array($type, ['Varchar', 'HTMLText'], true)) {
                    continue;
                }

                $fieldValue = (string) $fullPayload[$indexKey][$field];
                $barchars = ['!', ',', '.', '-'];
                $fieldValue = strip_tags($fieldValue);

                foreach($barchars as $badChar) {
                    $fieldValue = str_replace($badChar, '', $fieldValue);
                }

                $fieldValue = str_replace('/', ' ', $fieldValue);
                $textPayload[$indexKey][$field] = $fieldValue;
            }
        }

        return $textPayload;
    }
}
