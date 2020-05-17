<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Page;

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\ArrayData;
use Suilven\SphinxSearch\Service\Suggester;

class SearchPageController extends \PageController
{
    private static $allowed_actions = ['index'];

    private static $db = [
        'PageSize' => 'Int'
    ];

    private static $defaults = [
        'PageSize' => 10
    ];

    public function index()
    {
        // @todo search indexes addition
        $q = $this->getRequest()->getVar('q');

        /** @var array $selected */
        $selected = $this->getRequest()->getVars();

        /** @var SearchPage $model */
        $model = SearchPage::get_by_id('Suilven\FreeTextSearch\Page\SearchPage', $this->ID);


        unset($selected['start']);

        $results = [];


        //unset($selected['q']);

        if (!empty($q)  || $model->ShowAllIfEmptyQuery || !empty($selected)) {
            $results = $this->performSearchIncludingFacets($selected, $model, $q);
        }


        $results['Query'] = $q;


        // @todo In the case of facets and no search term this fails
        // This is intended for a search where a search term has been provided, but no results
        if (!empty($q) && $results['ResultsFound'] == 0) {
            // get suggestions
            $suggester = new Suggester();

            // @todo this is returning blank
            $suggester->setIndex($model->IndexToSearch);
            $suggestions = $suggester->suggest($q);

            $forTemplate = [];
            /*

            foreach($suggestions as $suggestion) {
                $forTemplate[] = ['Suggestions' => $suggestions];
            }
            */


           // $forTemplate = ['Suggestions' => $suggestions];
            $results['Suggestions'] = new ArrayList($suggestions);

            // @todo FIX - only one result returned for now
        }

        $facetted = isset($results['AllFacets']) ? true : false;



        $targetFacet = new ArrayList();
        if (!empty($model->ShowTagCloudFor)) {
            // get the tag cloud from calculated facets, but if not calculated, ie the arrive on the page case,
            // calculate them
            if ($facetted) {
                $facets = $results['AllFacets'];
            } else {
                $proxyResults = $this->performSearchIncludingFacets($selected, $model, $q);
                $facets = $proxyResults['AllFacets'];//
            }



            /** @var ArrayData $facet */
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
                $maxCount = $count > $maxCount ? $count : $maxCount;
            }

            $tagCloud = new ArrayList();
            foreach ($facetArray as $tag) {
                $size = $minSize + ($maxSize - $minSize) * $tag['Count'] / $maxCount;
                $size = round($size);
                $row = new ArrayData([
                    'Name' => $tag['Value'],
                    'Size' => $size,
                    'Params' => $tag['Params']
                ]);
                $tagCloud->push($row);
            }

            $results['TagCloud'] = $tagCloud;
        }


        //for($i = 3; $i < 40; $i++) {
           // echo "li.tag{$i} { font-size: {$i}px;};\n";
        //}


        // defer showing to the template level, still get facets, as this allows optionally for likes of a tag cloud
        $results['ShowAllIfEmptyQuery'] = $model->ShowAllIfEmptyQuery;
        $results['CleanedLink'] = $this->Link();

        return $results;
    }


    /**
     * @param array $selected
     * @param SearchPage $model
     * @param $q
     * @return array
     */
    public function performSearchIncludingFacets(array $selected, SearchPage $model, $q): array
    {
        // @todo Make generic, or at least config
        $searcher = new \Suilven\SphinxSearch\Service\Searcher();
        $searcher->setFilters($selected);
        $searcher->setIndexName($model->IndexToSearch);


        $facets = $model->getFacetFields();
        $hasManyFields = $model->getHasManyFields();

        $searcher->setFacettedTokens($facets);
        $searcher->setHasManyTokens($hasManyFields);


        if ($this->PageSize == 0) {
            $this->PageSize = 15;
        }
        $searcher->setPageSize($this->PageSize);
        $start = $this->getRequest()->getVar('start');


        // page 1 is the first page
        $page = empty($start) ? 1 : ($start / $this->PageSize) + 1;
        $searcher->setPage($page);
        $results = $searcher->search($q);
        return $results;
    }
}
