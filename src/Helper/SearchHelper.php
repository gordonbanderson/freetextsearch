<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Factory\IndexCreatorFactory;
use Suilven\FreeTextSearch\Indexes;


class SearchHelper
{
    /**
     * @param DataObject $dataObject
     */
    public function getTextFieldPayload($dataObject)
    {
        $helper = new IndexingHelper();
        $fullPayload = $helper->getFieldsToIndex($dataObject);

        $textPayload = [];

        $indices = new Indexes();
        $keys = array_keys($fullPayload);

        $specsHelper = new SpecsHelper();

        foreach($keys as $key) {
            if ($fullPayload[$key] !== []) {
                $index = $indices->getIndex($key);
                $textPayload[$key] = [];
                $specs = $specsHelper->getFieldSpecs($key);

                error_log('---- specs ----');
                error_log(print_r($specs, true));
                foreach (array_keys($specs) as $field) {
                    $type = $specs[$field];
                    if (in_array($type, ['Varchar', 'HTMLText'])) {
                        error_log('FIELD: ' . $field);
                        $textPayload[$key][$field] = $fullPayload[$key][$field];
                    }
                }
            }
        }

        unset($textPayload['Link']);
        return $textPayload;
    }
}
