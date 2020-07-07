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
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\NumericField;
use SilverStripe\ORM\DataExtension;

/**
 * Class FreeTextSearchSiteConfig
 *
 * @package Suilven\FreeTextSearch\SiteConfig
 *
 *  *
 * @package Suilven\FreeTextSearch\Page
 * @property int $BulkSize the number of DataObjects to index at once
 * @property bool $FreeTextSearchIndexingModeInBulk - show all or no results for an empty query
 */
class FreeTextSearchSiteConfig extends DataExtension
{
    /** @var array<string,string> */
    private static $db = [
        'BulkSize' => 'Int',
        'FreeTextSearchIndexingModeInBulk' => 'Boolean',
    ];

    /** @var array<string,int|string|bool> */
    private static $defaults = [
        'BulkSize' => 500,
        'FreeTextSearchIndexingModeInBulk' => false,
    ];


    /** @return \SilverStripe\Forms\FieldList<FormField> */
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
