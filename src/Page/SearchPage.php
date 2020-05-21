<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Page;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;
use Suilven\FreeTextSearch\Indexes;

/**
 * Class SearchPage
 * @package Suilven\FreeTextSearch\Page
 * @property string $IndexToSearch - the name of the index to search, defaults to SiteTree
 * @property integer  $PageSize the number of results to show on each page
 * @property boolean $ShowAllIfEmptyQuery - show all or no results for an empty query
 * @property string $ShowTagCloudFor - show a tag cloud
 */
class SearchPage extends \Page
{
    private static $table_name = 'SearchPage';

    /**
     * @var array database fields
     */
    private static $db = [
        // fields to return facets for, stored as JSON array
        // 'FacetFields' => 'Varchar(255)',

        // a permanent filter for this page, not user selectable.  Use case here is to restrict to likes of searching
        // within a specific blog only
        'IndexToSearch' => 'Varchar(255)',

        // page size
        'PageSize' => 'Int',

        // show all results if the search page has facets (optionally)
        'ShowAllIfEmptyQuery' => 'Boolean',

        // show all results if the search page has facets (optionally)
        'ShowTagCloudFor' => 'Varchar'
    ];

    private static $defaults = [
        'IndexToSearch' => 'sitetree'
    ];


    public function getFacetFields()
    {
        $indexesService = new Indexes();
        $facetFields = $indexesService->getFacetFields($this->IndexToSearch);
        return $facetFields;
    }

    public function getHasOneFields()
    {
        $indexesService = new Indexes();
        $hasManyFields = $indexesService->getHasOneFields($this->IndexToSearch);
        return $hasManyFields;
    }

    public function getHasManyFields()
    {
        $indexesService = new Indexes();
        $hasManyFields = $indexesService->getHasManyFields($this->IndexToSearch);
        return $hasManyFields;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $indexesService = new Indexes();
        $indexes = $indexesService->getIndexes();
        $indexNames = [];
        foreach ($indexes as $index) {
            $indexNames[$index->getName()] = $index->getName();
        }

        $fields->addFieldToTab('Root.Index', DropdownField::create(
            'IndexToSearch',
            'Index to Search',
            $indexNames
        ));

        $fields->addFieldToTab('Root.Index', NumericField::create('PageSize', 'Number of Results Per Page'));

        $fields->addFieldToTab('Root.Index', TextField::create(
            'ShowTagCloudFor',
            'Show a tag cloud for the named facet'
        ));

        $fields->addFieldToTab('Root.Index', CheckboxField::create(
            'ShowAllIfEmptyQuery',
            'By default no results are shown for an empty query.  However for facets an empty query should still ' .
            'provide for a drill down scenario'
        ));


        return $fields;
    }
}
