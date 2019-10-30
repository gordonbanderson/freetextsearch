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

        if (!empty($selected)  || $model->ShowAllIfEmptyQuery) {
            // @todo Make generic, or at least config
            $searcher = new \Suilven\SphinxSearch\Service\Searcher();
            $searcher->setFilters($selected);
            $searcher->setIndexName($model->IndexToSearch);

            $facets = $model->getFacetFields();
            $hasManyFields = $model->getHasManyFields();

            $searcher->setFacettedTokens($facets);
            $searcher->setHasManyTokens($hasManyFields);


            if ($this->PageSize == 0) {
                $this->PageSize=15;
            }
            $searcher->setPageSize($this->PageSize);
            $start = $this->getRequest()->getVar('start');


            // page 1 is the first page
            $page = empty($start) ? 1 : ($start/$this->PageSize) + 1;
            $searcher->setPage($page);
            $results = $searcher->search($q);
            $results['Query'] = $q;
        }

        // @todo In the case of facets and no search term this fails
        // This is intended for a search where a search term has been provided, but no results
        if (!empty($q) && $results['ResultsFound'] == 0) {
            // get suggestions
            $suggester = new Suggester();
            $suggester->setIndex($model->IndexToSearch);
            $suggestions = $suggester->suggest($q);

            $forTemplate = [];
            foreach($suggestions as $suggestion) {
                $forTemplate[] = ['Suggestion' => $suggestion];
            }
            //$results['Suggestions'] = new ArrayList($forTemplate);

            // @todo FIX - only one result returned for now

        }

        $facetted = isset($results['AllFacets']) ? true : false;


        $results['CleanedLink'] = $this->Link();

        return $results;



    }
}
