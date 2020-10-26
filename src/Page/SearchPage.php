<?php declare(strict_types = 1);

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
use Suilven\FreeTextSearch\Container\SearchResults;
use Suilven\FreeTextSearch\Indexes;

/**
 * Class SearchPage
 *
 * @package Suilven\FreeTextSearch\Page
 * @property string $IndexToSearch - the name of the index to search, defaults to SiteTree
 * @property int $PageSize the number of results to show on each page
 * @property bool $ShowAllIfEmptyQuery - show all or no results for an empty query
 * @property string $ShowTagCloudFor - show a tag cloud
 */
class SearchPage extends \Page
{
    /** @var \Suilven\FreeTextSearch\Container\SearchResults */
    private $searchResults;

    /** @var string */
    private static $table_name = 'SearchPage';

    /** @var array database fields */
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
        'ShowTagCloudFor' => 'Varchar',
    ];

    /** @var array<string,int|bool|string|float> */
    private static $defaults = [
        'IndexToSearch' => 'sitetree',
        'ShowInsearch' => false,
        // same as Laravel
        'PageSize' => 15,
    ];

    /**
     * Accessor to the search results object
     */
    public function getSearchResults(): SearchResults
    {
        return $this->searchResults;
    }


    public function setSearchResults(SearchResults $newSearchResults): void
    {
        $this->searchResults = $newSearchResults;
    }


    /**
     * Get the fields to facet on
     *
     * @return array<string>
     */
    public function getFacetFields(): array
    {
        $indexesService = new Indexes();

        return $indexesService->getFacetFields($this->IndexToSearch);
    }


    /**
     * Get the has many fields
     *
     * @return array<string>
     */
    public function getHasManyFields(): array
    {
        $indexesService = new Indexes();

        $fieldDetails = $indexesService->getHasManyFields($this->IndexToSearch);
        $result = [];
        foreach ($fieldDetails as $detail) {
            $result[] = $detail['name'];
        }

        return $result;
    }


    public function getCMSFields(): \SilverStripe\Forms\FieldList
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
