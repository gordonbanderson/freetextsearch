<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Page;

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use Suilven\FreeTextSearch\Container\SearchResults;
use Suilven\FreeTextSearch\Factory\SearcherFactory;

// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

/**
 * Class SearchPageController
 *
 * @package Suilven\FreeTextSearch\Page
 * @property int $ID Page ID
 * @property int $PageSize the number of results to show on each page
 */

class SearchPageController extends \PageController
{
    /** @var array<string> */
    private static $allowed_actions = ['index'];

    /** @var array<string,string> */
    private static $db = [
        'PageSize' => 'Int',
    ];

    /** @var array<string,int|float|string> */
    private static $defaults = [
        'PageSize' => 10,
    ];

    public function index(): \SilverStripe\View\ViewableData_Customised
    {
        // @todo search indexes addition
        $q = $this->getRequest()->getVar('q');

        /** @var array $selected */
        $selected = $this->getRequest()->getVars();

        /** @var \Suilven\FreeTextSearch\Page\SearchPage $model */
        $model = SearchPage::get_by_id(SearchPage::class, $this->ID);


        unset($selected['start']);

        $results = new SearchResults();


        //unset($selected['q']);

        if (isset($q) || $model->ShowAllIfEmptyQuery || isset($selected['q'])) {
            $results = $this->performSearchIncludingFacets($selected, $model, $q);
        }


        $results->setQuery($q);






        /*
         *
         *         // get suggestions

        $factory = new SuggesterFactory();

        $suggester = $factory->getSuggester();

        // @todo this is returning blank
        $suggester->setIndex($model->IndexToSearch);
        $suggestions = $suggester->suggest($q);




        $facetted = isset($results['AllFacets']);



        $targetFacet = new ArrayList();
        if (isset($model->ShowTagCloudFor)) {
            // get the tag cloud from calculated facets, but if not calculated, ie the arrive on the page case,
            // calculate them
            if ($facetted) {
                $facets = $results['AllFacets'];
            } else {
                $proxyResults = $this->performSearchIncludingFacets($selected, $model, $q);
                $facets = $proxyResults['AllFacets'];
            }

            foreach ($facets as $facet) {
                $name = $facet->getField('Name');
                if ($name === $model->ShowTagCloudFor) {
                    $targetFacet = $facet->getField('Facets');

                    break;
                }
            }

            $facetArray = $targetFacet->toArray();
            $minSize = 10;
            $maxSize = 40;
            $maxCount = 0;
            foreach ($facetArray as $tag) {
                $count = $tag['Count'];
                $maxCount = $count > $maxCount
                    ? $count
                    : $maxCount;
            }

            $tagCloud = new ArrayList();
            foreach ($facetArray as $tag) {
                $size = $minSize + ($maxSize - $minSize) * $tag['Count'] / $maxCount;
                $size = \round($size);
                $row = new ArrayData([
                    'Name' => $tag['Value'],
                    'Size' => $size,
                    'Params' => $tag['Params'],
                ]);
                $tagCloud->push($row);
            }

            $results['TagCloud'] = $tagCloud;
        }


        //for($i = 3; $i < 40; $i++) {
           // echo "li.tag{$i} { font-size: {$i}px;};\n";
        //}

        */


        // defer showing to the template level, still get facets, as this allows optionally for likes of a tag cloud
        // $results['ShowAllIfEmptyQuery'] = $model->ShowAllIfEmptyQuery;
        // $results['CleanedLink'] = $this->Link();

        $records = $results->getRecords();
        $newRecords = new ArrayList();
        foreach ($records as $record) {
            $highsList = new ArrayList();
            $highlightsArray = $record->Highlights;

            $keys = \array_keys($highlightsArray);
            foreach ($keys as $highlightedField) {
                foreach ($highlightsArray[$highlightedField] as $highlightsForField) {
                    $do = new DataObject();
                    // @phpstan-ignore-next-line
                    $do->Snippet = '...' . $highlightsForField . '...';

                    $highsList->push($do);
                }
            }



            $record->Highlights = $highsList;
            $newRecords->push($record);
        }

        return $this->customise(new ArrayData([
            'NumberOfResults' => $results->getNumberOfResults(),
            'Query' => $results->getQuery(),
            'Records' => $newRecords,
            'Page' => $results->getPage(),
            'PageSize' => $results->getPageSize(),
            'Suggestions' => new ArrayList($results->getSuggestions()),
            'Time' => $results->getTime(),
        ]));
    }


    /** @param array<string,int|string|float|bool> $selected */
    public function performSearchIncludingFacets(array $selected, SearchPage $searchPage, ?string $q): SearchResults
    {
        $factory = new SearcherFactory();

        /** @var \Suilven\FreeTextSearch\Interfaces\Searcher $searcher */
        $searcher = $factory->getSearcher();
        $searcher->setFilters($selected);
        $searcher->setIndexName($searchPage->IndexToSearch);


        $facets = $searchPage->getFacetFields();
        $hasManyFields = $searchPage->getHasManyFields();

        $searcher->setFacettedTokens($facets);
        $searcher->setHasManyTokens($hasManyFields);


        if ($this->PageSize === 0) {
            $this->PageSize = 15;
        }
        $searcher->setPageSize($this->PageSize);
        $start = $this->getRequest()->getVar('start');


        // page 1 is the first page
        $page = isset($start)
            ? ($start / $this->PageSize) + 1
            : 1;
        $searcher->setPage($page);

        return $searcher->search($q);
    }
}
