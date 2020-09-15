<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObject;

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

        foreach ($keys as $key) {
            if ($fullPayload[$key] === []) {
                continue;
            }

            $textPayload[$key] = [];
            $specs = $specsHelper->getFieldSpecs($key);

            foreach (\array_keys($specs) as $field) {
                // skip link field
                if ($field === 'Link') {
                    continue;
                }
                $type = $specs[$field];
                if (!\in_array($type, ['Varchar', 'HTMLText'], true)) {
                    continue;
                }

                $fieldValue = (string) $fullPayload[$key][$field];
                $barchars = ['!', ',', '.'];
                $fieldValue = strip_tags($fieldValue);

                foreach($barchars as $badChar) {
                    $fieldValue = str_replace($badChar, '', $fieldValue);
                }
                $textPayload[$key][$field] = $fieldValue;
            }
        }

        return $textPayload;
    }
}
