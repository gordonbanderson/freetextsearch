<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Page;

use SilverStripe\Forms\DropdownField;
use Suilven\FreeTextSearch\Indexes;

class SearchPage extends \Page
{
    private static $table_name = 'SearchPage';

    /**
     * @var array database fields
     */
    private static $db = [
        // fields to return facets for, stored as JSON array
        'FacetFields' => 'Varchar(255)',

        // a permanent filter for this page, not user selectable.  Use case here is to restrict to likes of searching
        // within a specific blog only
        'IndexToSearch' => 'Varchar(255)',

        // page size
        'PageSize' => 'Int'

    ];

    private static $defaults = [
        'IndexToSearch' => 'sitetree'
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $indexesService = new Indexes();
        $indexes = $indexesService->getIndexes();
        $indexNames = [];
        foreach($indexes as $index) {
            $indexNames[$index->getName()] = $index->getName();
        }

        $fields->addFieldToTab('Root.Index', DropdownField::create('IndexToSearch','Index to Search',
            $indexNames));
        return $fields;
    }


    /**
     * // Comment this out for reference purposes until I remember how it's supposed to work!
    public function wibble()
    {
        $indexesService = new Indexes();
        $indexes = $indexesService->getIndexes();
    }
     * */
}
