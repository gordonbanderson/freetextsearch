<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\SiteConfig;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\ORM\DataExtension;

class FreeTextSearchSiteConfig extends DataExtension
{
    private static $db = [
        'BulkSize' => 'Int',
        'FreeTextSearchIndexingModeInBulk' => 'Boolean',
    ];

    private static $defaults = [
        'BulkSize' => 500,
        'FreeTextSearchIndexingModeInBulk' => false,
    ];


    public function updateCMSFields(FieldList $fields): FieldList
    {
        $fields->addFieldToTab("Root.FreeTextSearch", new NumericField(
            "BulkSize",
            'The number of documents to index at once in bulk'
        ));
        $fields->addFieldToTab(
            'Root.FreeTextSearch',
            new CheckboxField(
                'FreeTextSearchIndexingModeInBulk',
                'True to index in bulk, false to index individually'
            )
        );

        return $fields;
    }
}
